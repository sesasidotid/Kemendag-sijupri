<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\EyegilLms\Dtos\ChecklistDto;
use Eyegil\EyegilLms\Enums\Choices;
use Eyegil\EyegilLms\Services\QuestionService;
use Eyegil\EyegilLms\Dtos\MultipleChoiceDto;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Enums\QuestionType;
use Eyegil\SijupriMaintenance\Services\KompetensiIndikatorService;
use Eyegil\SijupriUkom\Dtos\UkomModuleQuestionDto;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Symfony\Component\Mime\MimeTypes;

class UkomModuleService
{
    public function __construct(
        private QuestionService $questionService,
        private StorageService $storageService,
        private StorageSystemService $storageSystemService,
        private KompetensiIndikatorService $kompetensiIndikatorService,
    ) {
    }

    public function downloadTemplate($exam_type)
    {
        switch ($exam_type) {
            case ExamTypes::CAT->value:
                return $this->storageSystemService->downloadFile("template", "cat_question_template.xlsx");
            case ExamTypes::MAKALAH->value:
                return $this->storageSystemService->downloadFile("template", "makalah_question_template.xlsx");
            case ExamTypes::WAWANCARA->value:
                return $this->storageSystemService->downloadFile("template", "wawancara_question_template.xlsx");
            case ExamTypes::PORTOFOLIO->value:
                return $this->storageSystemService->downloadFile("template", "portofolio_question_template.xlsx");
            case ExamTypes::PRAKTIK->value:
                return $this->storageSystemService->downloadFile("template", "praktik_question_template.xlsx");
            case ExamTypes::STUDI_KASUS->value:
                return $this->storageSystemService->downloadFile("template", "studi_kasus_question_template.xlsx");
            default:
                throw new RecordNotFoundException("exam_type not exist");
        }
    }

    // public function saveQuestion(UkomModuleQuestionDto $ukomModuleQuestionDto)
    // {
    //     return DB::transaction(function () use ($ukomModuleQuestionDto) {
    //         $questionDto = new QuestionDto();
    //         $questionDto->question = $this->sanitizeInput($ukomModuleQuestionDto->question);

    //         if ($ukomModuleQuestionDto->exam_type == ExamTypes::MAKALAH->name) {
    //             $questionDto->module_id = ExamTypes::MAKALAH;
    //             $questionDto->type = QuestionType::UPLOADS;
    //             $this->questionService->save($questionDto);
    //         }

    //         return $questionDto;
    //     });
    // }

    // public function updateQuestion(UkomModuleQuestionDto $ukomModuleQuestionDto)
    // {
    //     return DB::transaction(function () use ($ukomModuleQuestionDto) {
    //         $questionDto = new QuestionDto();
    //         $questionDto->id = $ukomModuleQuestionDto->id;
    //         $questionDto->question = $this->sanitizeInput($ukomModuleQuestionDto->question);

    //         if ($ukomModuleQuestionDto->exam_type == ExamTypes::MAKALAH->name) {
    //             $questionDto->module_id = ExamTypes::MAKALAH;
    //             $questionDto->type = QuestionType::UPLOADS;
    //             $this->questionService->update($questionDto);
    //         }

    //         return $questionDto;
    //     });
    // }

    public function saveQuestionFromSheet(UkomModuleQuestionDto $ukomModuleQuestionDto)
    {
        DB::transaction(function () use ($ukomModuleQuestionDto) {
            $object_name = $this->storageService->putObjectFromBase64WithFilename("system", "lms", "questions_" . Carbon::now()->format('YmdHis'), $ukomModuleQuestionDto->file_question);
            $bucket_path = $this->storageSystemService->getFileLocation("lms", $object_name);
            $file_location = storage_path('app/' . $bucket_path);

            try {
                $spreadsheet = IOFactory::load($file_location);
                $sheet = $spreadsheet->getActiveSheet();
                $imageMap = $this->extractImage($sheet);

                $data = [];
                foreach ($sheet->getRowIterator() as $row) {
                    $rowData = [];
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    foreach ($cellIterator as $cell) {
                        $rowData[] = $cell->getValue();
                    }

                    $data[] = $rowData;
                }

                switch ($ukomModuleQuestionDto->exam_type) {
                    case ExamTypes::CAT->value:
                        $this->saveCatFromSheet($data, $imageMap);
                        break;
                    case ExamTypes::MAKALAH->value:
                        $this->saveMakalahFromSheet($data, $imageMap);
                        break;
                    case ExamTypes::WAWANCARA->value:
                        $this->saveWawancaraFromSheet($data, $imageMap);
                        break;
                    case ExamTypes::PORTOFOLIO->value:
                        $this->savePortofolioFromSheet($data, $imageMap);
                        break;
                    case ExamTypes::STUDI_KASUS->value:
                        $this->saveStudiKasusFromSheet($ukomModuleQuestionDto->upload_soal_list, $data, $imageMap);
                        break;
                    case ExamTypes::PRAKTIK->value:
                        $this->savePraktikFromSheet($data, $imageMap);
                        break;
                    default:
                        throw new RecordNotFoundException("exam_type not exist");
                }
            } finally {
                if (file_exists($file_location)) {
                    unlink($file_location);
                }
            }
        });
    }

    private function saveCatFromSheet($data, $imageMap): void
    {
        DB::transaction(function () use ($data, $imageMap) {
            foreach ($data as $rowIndex => $value) {
                if ($rowIndex == 0)
                    continue;

                $questionDto = new QuestionDto();
                $questionDto->question = $this->sanitizeInput($value[0]);
                $questionDto->module_id = ExamTypes::CAT;
                $questionDto->type = QuestionType::MULTI_CHOICE;
                if (isset($imageMap["C" . ($rowIndex + 1)])) {
                    $questionDto->attachment = $imageMap["C" . ($rowIndex + 1)];
                }
                $questionDto->multiple_choice_dto_list = [];

                if (empty($value[1]) || !in_array(strtolower($value[1]), array_map(fn($choice) => $choice->value, Choices::cases()))) {
                    throw new BusinessException("invalid answer", "");
                }

                $multipleChoiceDtoA = new MultipleChoiceDto();
                $multipleChoiceDtoA->choice_id = Choices::A->value;
                $multipleChoiceDtoA->choice_value = $value[3];
                $multipleChoiceDtoA->correct = (strtolower($value[1]) == Choices::A->value);
                $questionDto->multiple_choice_dto_list[] = $multipleChoiceDtoA;

                $multipleChoiceDtoB = new MultipleChoiceDto();
                $multipleChoiceDtoB->choice_id = Choices::B->value;
                $multipleChoiceDtoB->choice_value = $value[4];
                $multipleChoiceDtoB->correct = (strtolower($value[1]) == Choices::B->value);
                $questionDto->multiple_choice_dto_list[] = $multipleChoiceDtoB;

                $multipleChoiceDtoC = new MultipleChoiceDto();
                $multipleChoiceDtoC->choice_id = Choices::C->value;
                $multipleChoiceDtoC->choice_value = $value[5];
                $multipleChoiceDtoC->correct = (strtolower($value[1]) == Choices::C->value);
                $questionDto->multiple_choice_dto_list[] = $multipleChoiceDtoC;

                $multipleChoiceDtoD = new MultipleChoiceDto();
                $multipleChoiceDtoD->choice_id = Choices::D->value;
                $multipleChoiceDtoD->choice_value = $value[6];
                $multipleChoiceDtoD->correct = (strtolower($value[1]) == Choices::D->value);
                $questionDto->multiple_choice_dto_list[] = $multipleChoiceDtoD;

                if (isset($value[6]) && $value[6]) {
                    $multipleChoiceDtoE = new MultipleChoiceDto();
                    $multipleChoiceDtoE->choice_id = Choices::E->value;
                    $multipleChoiceDtoE->choice_value = $value[7];
                    $multipleChoiceDtoE->correct = (strtolower($value[1]) == Choices::E->value);
                    $questionDto->multiple_choice_dto_list[] = $multipleChoiceDtoE;
                }

                $kompetensiIndikator = $this->kompetensiIndikatorService->findByCode($value[8]);
                if (!$kompetensiIndikator) {
                    throw new RecordNotFoundException("code not found", ["code" => $value[8]]);
                }

                $questionDto->association = $kompetensiIndikator->getTable();
                $questionDto->association_id = $kompetensiIndikator->id;
                $this->questionService->save($questionDto);
            }
        });
    }

    private function saveMakalahFromSheet($data, $imageMap): void
    {
        DB::transaction(function () use ($data, $imageMap) {
            $question = $this->questionService->findByIdV2("base_makalah_question");
            if (!$question) {
                $questionDto = new QuestionDto();
                $questionDto->id = "base_makalah_question";
                $questionDto->question = "Silahkan upload makalah Anda sesuai dengan instruksi yang diberikan.";
                $questionDto->module_id = ExamTypes::MAKALAH;
                $questionDto->type = QuestionType::UPLOADS;
                $question = $this->questionService->saveV2($questionDto);
            }

            foreach ($data as $rowIndex => $value) {
                if ($rowIndex == 0)
                    continue;

                $questionDto = new QuestionDto();
                $questionDto->parent_question_id = $question->id;
                $questionDto->question = $this->sanitizeInput($value[0]);
                $questionDto->module_id = ExamTypes::MAKALAH;
                $questionDto->type = QuestionType::UPLOADS;
                if (isset($imageMap["B" . ($rowIndex + 1)])) {
                    $questionDto->attachment = $imageMap["B" . ($rowIndex + 1)];
                }
                if ($value[2] === null) {
                    throw new BusinessException("invalid weight", "");
                }
                $questionDto->weight = (float) $value[2];

                if (!in_array(Str::lower($value[3]), ["a", "b", "c"])) {
                    throw new RecordNotFoundException("code not found", ["code" => $value[3]]);
                }

                $questionDto->association = "komponen";
                $questionDto->association_id = $value[3];

                $this->questionService->deleteByModuleIdAndAssociationAndAssociationId(ExamTypes::WAWANCARA, $questionDto->association, $questionDto->association_id);
                $this->questionService->save($questionDto);
            }
        });
    }

    private function saveWawancaraFromSheet($data, $imageMap): void
    {
        DB::transaction(function () use ($data, $imageMap) {
            $this->questionService->deleteByModuleId(ExamTypes::WAWANCARA);

            foreach ($data as $rowIndex => $value) {
                if ($rowIndex == 0)
                    continue;

                $questionDto = new QuestionDto();
                $questionDto->question = $this->sanitizeInput($value[0]);
                $questionDto->module_id = ExamTypes::WAWANCARA;
                $questionDto->type = QuestionType::ESSAY;
                $questionDto->hint = $value[2];
                if (isset($imageMap["B" . ($rowIndex + 1)])) {
                    $questionDto->attachment = $imageMap["B" . ($rowIndex + 1)];
                }
                if ($value[3] === null) {
                    throw new BusinessException("invalid weight", "");
                }
                $questionDto->weight = (float) $value[3];

                $questionDto->multiple_choice_dto_list = [];

                $multipleChoiceDtoKompeten = new MultipleChoiceDto();
                $multipleChoiceDtoKompeten->choice_id = "kompeten";
                $multipleChoiceDtoKompeten->choice_value = "Kompeten";
                $multipleChoiceDtoKompeten->correct = true;
                $questionDto->multiple_choice_dto_list[] = $multipleChoiceDtoKompeten;

                $multipleChoiceDtoTidakKompeten = new MultipleChoiceDto();
                $multipleChoiceDtoTidakKompeten->choice_id = "tidak_kompeten";
                $multipleChoiceDtoTidakKompeten->choice_value = "Tidak Kompeten";
                $multipleChoiceDtoTidakKompeten->correct = false;
                $questionDto->multiple_choice_dto_list[] = $multipleChoiceDtoTidakKompeten;

                $kompetensiIndikator = $this->kompetensiIndikatorService->findByCode($value[4]);
                if (!$kompetensiIndikator) {
                    throw new RecordNotFoundException("code not found", ["code" => $value[4]]);
                }

                $questionDto->association = $kompetensiIndikator->getTable();
                $questionDto->association_id = $kompetensiIndikator->id;

                $this->questionService->deleteByModuleIdAndAssociationAndAssociationId(ExamTypes::WAWANCARA, $questionDto->association, $questionDto->association_id);
                $this->questionService->save($questionDto);
            }
        });
    }

    private function savePortofolioFromSheet($data, $imageMap): void
    {
        DB::transaction(function () use ($data, $imageMap) {
            foreach ($data as $rowIndex => $value) {
                if ($rowIndex == 0)
                    continue;

                $questionDto = new QuestionDto();
                $questionDto->question = $this->sanitizeInput($value[0]);
                $questionDto->module_id = ExamTypes::PORTOFOLIO;
                $questionDto->type = QuestionType::UPLOADS;
                if (isset($imageMap["B" . ($rowIndex + 1)])) {
                    $questionDto->attachment = $imageMap["B" . ($rowIndex + 1)];
                }
                if ($value[2] === null) {
                    throw new BusinessException("invalid weight", "");
                }
                $questionDto->weight = (float) $value[2];


                $questionDto->checklist_dto_list = [];

                $checklistValid = new ChecklistDto();
                $checklistValid->list_id = "valid";
                $checklistValid->checked = true;
                $questionDto->checklist_dto_list[] = $checklistValid;

                $checklistTidakMemadai = new ChecklistDto();
                $checklistTidakMemadai->list_id = "memadai";
                $checklistTidakMemadai->checked = true;
                $questionDto->checklist_dto_list[] = $checklistTidakMemadai;


                $kompetensiIndikator = $this->kompetensiIndikatorService->findByCode($value[3]);
                if (!$kompetensiIndikator) {
                    throw new RecordNotFoundException("code not found", ["code" => $value[3]]);
                }



                $questionDto->association = $kompetensiIndikator->getTable();
                $questionDto->association_id = $kompetensiIndikator->id;

                $this->questionService->deleteByModuleIdAndAssociationAndAssociationId(ExamTypes::PORTOFOLIO, $questionDto->association, $questionDto->association_id);
                $this->questionService->save($questionDto);
            }
        });
    }

    private function savePraktikFromSheet($data, $imageMap): void
    {
        DB::transaction(function () use ($data, $imageMap) {
            $question = $this->questionService->findByIdV2("base_praktik_question");
            if (!$question) {
                $questionDto = new QuestionDto();
                $questionDto->id = "base_praktik_question";
                $questionDto->question = "Silahkan upload jawaban anda dan masukkan link drive anda";
                $questionDto->module_id = ExamTypes::PRAKTIK;
                $questionDto->type = QuestionType::UPLOADS;
                $question = $this->questionService->saveV2($questionDto);
            } else {
                $question->id = "base_praktik_question";
                $question->question = "Silahkan upload jawaban anda dan masukkan link drive anda";
                $question->module_id = ExamTypes::PRAKTIK;
                $question->type = QuestionType::UPLOADS;
                $question->save();
            }

            $this->questionService->deleteByParentQuestionId($question->id);

            foreach ($data as $rowIndex => $value) {
                if ($rowIndex == 0)
                    continue;

                $questionDto = new QuestionDto();
                $questionDto->parent_question_id = $question->id;
                $questionDto->question = $this->sanitizeInput($value[0]);
                $questionDto->module_id = ExamTypes::PRAKTIK;
                $questionDto->type = QuestionType::ESSAY;
                if (isset($imageMap["B" . ($rowIndex + 1)])) {
                    $questionDto->attachment = $imageMap["B" . ($rowIndex + 1)];
                }
                if ($value[2] === null) {
                    throw new BusinessException("invalid weight", "");
                }
                $questionDto->weight = (float) $value[2];

                $this->questionService->save($questionDto);
            }
        });
    }

    private function saveStudiKasusFromSheet($upload_soal_list, $data, $imageMap): void
    {
        DB::transaction(function () use ($upload_soal_list, $data, $imageMap) {
            $this->questionService->deleteByModuleIdAndAssociationAndAssociationId(ExamTypes::STUDI_KASUS->value, 'examiner_studi_kasus', 'examiner_studi_kasus');

            foreach ($data as $rowIndex => $value) {
                if ($rowIndex == 0)
                    continue;

                $questionDto = new QuestionDto();
                $questionDto->question = $this->sanitizeInput($value[0]);
                $questionDto->module_id = ExamTypes::STUDI_KASUS;
                $questionDto->type = QuestionType::UPLOADS;
                if (isset($imageMap["B" . ($rowIndex + 1)])) {
                    $questionDto->attachment = $imageMap["B" . ($rowIndex + 1)];
                }
                if ($value[2] === null) {
                    throw new BusinessException("invalid weight", "");
                }
                $questionDto->weight = (float) $value[2];


                $questionDto->association = "examiner_studi_kasus";
                $questionDto->association_id = "examiner_studi_kasus";
                $this->questionService->save($questionDto);
            }

            foreach ($upload_soal_list as $upload_soal) {
                $soal_name = $this->storageService->putObjectFromBase64WithFilename("system", "lms", "soal_" . $upload_soal['code'] . Carbon::now()->format('YmdHis'), $upload_soal['file']);

                $questionDto = new QuestionDto();
                $questionDto->question = "Silahkan unduh soal ujian";
                $questionDto->attachment = $soal_name;
                $questionDto->module_id = ExamTypes::STUDI_KASUS;
                $questionDto->type = QuestionType::UPLOADS;

                $kompetensiIndikator = $this->kompetensiIndikatorService->findByCode($upload_soal['code']);
                if (!$kompetensiIndikator) {
                    throw new RecordNotFoundException("code not found", ["code" => $upload_soal['code']]);
                }

                $questionDto->association = $kompetensiIndikator->getTable();
                $questionDto->association_id = $kompetensiIndikator->id;
                $this->questionService->deleteByModuleIdAndAssociationAndAssociationId(ExamTypes::STUDI_KASUS->value, $questionDto->association, $questionDto->association_id);

                $this->questionService->save($questionDto);
            }
        });
    }

    private function extractImage($sheet)
    {
        $i = 0;
        $imageMap = [];

        foreach ($sheet->getDrawingCollection() as $drawing) {
            $coordinates = $drawing->getCoordinates();
            $extension = '';
            $imageContents = '';

            if ($drawing instanceof MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();

                switch ($drawing->getMimeType()) {
                    case MemoryDrawing::MIMETYPE_PNG:
                        $extension = 'png';
                        break;
                    case MemoryDrawing::MIMETYPE_GIF:
                        $extension = 'gif';
                        break;
                    case MemoryDrawing::MIMETYPE_JPEG:
                        $extension = 'jpg';
                        break;
                }
            } else {
                if ($drawing->getPath()) {
                    if ($drawing->getIsURL()) {
                        $imageContents = file_get_contents($drawing->getPath());
                        $filePath = tempnam(sys_get_temp_dir(), 'Drawing');
                        file_put_contents($filePath, $imageContents);
                        $mimeType = mime_content_type($filePath);

                        $mimeTypes = new MimeTypes();
                        $extensions = $mimeTypes->getExtensions($mimeType);

                        if (empty($extensions)) {
                            throw new BusinessException("Unsupported MIME type or extension could not be determined", "STO-XXXXX");
                        }

                        $extension = $extensions[0];
                        unlink($filePath);
                    } else {
                        $zipReader = fopen($drawing->getPath(), 'r');
                        while (!feof($zipReader)) {
                            $imageContents .= fread($zipReader, 1024);
                        }
                        fclose($zipReader);
                        $extension = $drawing->getExtension();
                    }
                }
            }

            $imageFilename = 'lms_question_' . Carbon::now()->format('YmdHis') . '_' . ++$i . '.' . $extension;
            $imageLocation = storage_path('app/buckets/lms/' . $imageFilename);
            file_put_contents($imageLocation, $imageContents);

            $imageMap[$coordinates] = $imageFilename;
        }

        return $imageMap;
    }

    private function sanitizeInput($value)
    {
        $value = trim($value);
        if ($value === null || $value === '') {
            throw new BusinessException("Input cannot be null or empty", "VAL-0002");
        }

        return $value;
    }
}
