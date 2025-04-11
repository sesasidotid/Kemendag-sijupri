<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\EyegilLms\Enums\Choices;
use Eyegil\EyegilLms\Services\QuestionService;
use Eyegil\EyegilLms\Dtos\MultipleChoiceDto;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Enums\QuestionType;
use Eyegil\SijupriMaintenance\Services\KompetensiService;
use Eyegil\SijupriUkom\Dtos\UkomModuleQuestionDto;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Symfony\Component\Mime\MimeTypes;

class UkomModuleService
{
    public function __construct(
        private QuestionService $questionService,
        private StorageService $storageService,
        private StorageSystemService $storageSystemService,
        private KompetensiService $kompetensiService,
    ) {}

    public function downloadTemplate($exam_type)
    {
        switch ($exam_type) {
            case ExamTypes::CAT->value:
                return $this->storageSystemService->downloadFile("template", "cat_question_template.xlsx");
            default:
                throw new RecordNotFoundException("exam_type not exist");
        }
    }

    public function saveQuestion(UkomModuleQuestionDto $ukomModuleQuestionDto)
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
                if ($rowIndex == 0) continue;

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

                $kompetensi = $this->kompetensiService->findByCode($value[8]);
                if (!$kompetensi) {
                    throw new RecordNotFoundException("code not found", ["code" => $value[8]]);
                }

                $questionDto->association = $kompetensi->getTable();
                $questionDto->association_id = $kompetensi->id;
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
