<?php

namespace Eyegil\SijupriUkom\Jobs;

use Carbon\Carbon;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Enums\ExamTypesMansoskul;
use Eyegil\SijupriUkom\Models\ExamGrade;
use Eyegil\SijupriUkom\Models\ExamGradeMansoskul;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Eyegil\SijupriUkom\Models\UkomFormula;
use Eyegil\SijupriUkom\Models\UkomGrade;
use Eyegil\SijupriUkom\Services\ExamGradeService;
use Eyegil\SijupriUkom\Services\ParticipantUkomService;
use Eyegil\SijupriUkom\Services\UkomBanService;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class UkomGradeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 1;

    protected $file_grade;

    public function __construct($file_grade)
    {
        $this->file_grade = $file_grade;
    }

    public function handle(
        ParticipantUkomService $participantUkomService,
        ExamGradeService $examGradeService,
        StorageService $storageService,
        StorageSystemService $storageSystemService,
        UkomBanService $ukomBanService,
    ): void {
        DB::transaction(function () use ($participantUkomService, $examGradeService, $storageService, $storageSystemService, $ukomBanService) {

            $object_name = $storageService->putObjectFromBase64WithFilename("system", "ukom", "grade_" . Carbon::now()->format('YmdHis'), $this->file_grade);
            $file_location_grade = storage_path('app/' . $storageSystemService->getFileLocation("ukom", $object_name));
            try {
                $spreadsheet = IOFactory::load($file_location_grade);
                $sheet = $spreadsheet->getActiveSheet();
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

                foreach ($data as $key => $value) {
                    if ($key == 0) continue;

                    Log::info("UKOM GRADE : getting participant with nip/email of " . $value[0]);
                    $participantUkom = $participantUkomService->findByNipOrEmail($value[0]);
                    if ($participantUkom) {
                        Log::info("UKOM GRADE : participant with nip/email of " . $value[0] . "found");

                        Log::info("UKOM GRADE : getting the participan room of participant with nip/email of " . $value[0]);
                        $participantRoomUkom = $participantUkom->participantRoomUkom;
                        if ($participantRoomUkom) {
                            Log::info("UKOM GRADE : participan room of participant with nip/email of " . $value[0] . "found");

                            Log::info("UKOM GRADE : getting the ukom grade of participant with nip/email of " . $value[0]);
                            $ukomGrade = UkomGrade::where("room_ukom_id", $participantRoomUkom->room_id)
                                ->where("participant_id", $participantUkom->id)->first() ?? new UkomGrade();

                            $examGradeCat = $examGradeService->findByOnlyExamTypeCodeAndRoomUkomIdAndParticipantId(
                                ExamTypes::CAT->value,
                                $participantRoomUkom->room_id,
                                $participantUkom->id
                            );

                            if (!$examGradeCat) {
                                Log::warning("UKOM GRADE : UKOM GRADE : participant with nip " . $value[0] . " have not finished CAT yet");
                                continue;
                            }

                            $ukomGrade->cat_grade_id = $examGradeCat->id;

                            $examGradeWawancara = new ExamGrade();
                            $examGradeWawancara->exam_type_code = ExamTypes::WAWANCARA->value;
                            $examGradeWawancara->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeWawancara->participant_id = $participantUkom->id;
                            $examGradeWawancara->score = $value[1];
                            $examGradeWawancara->saveWithUuid();
                            $ukomGrade->wawancara_grade_id = $examGradeWawancara->id;

                            $examGradeSeminar = new ExamGrade();
                            $examGradeSeminar->exam_type_code = ExamTypes::SEMINAR->value;
                            $examGradeSeminar->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeSeminar->participant_id = $participantUkom->id;
                            $examGradeSeminar->score = $value[2];
                            $examGradeSeminar->saveWithUuid();
                            $ukomGrade->seminar_grade_id = $examGradeSeminar->id;

                            $examGradePraktik = new ExamGrade();
                            $examGradePraktik->exam_type_code = ExamTypes::PRAKTIK->value;
                            $examGradePraktik->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradePraktik->participant_id = $participantUkom->id;
                            $examGradePraktik->score = $value[3];
                            $examGradePraktik->saveWithUuid();
                            $ukomGrade->praktik_grade_id = $examGradePraktik->id;

                            $examGradePortofolio = new ExamGrade();
                            $examGradePortofolio->exam_type_code = ExamTypes::PORTOFOLIO->value;
                            $examGradePortofolio->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradePortofolio->participant_id = $participantUkom->id;
                            $examGradePortofolio->score = $value[4];
                            $examGradePortofolio->saveWithUuid();
                            $ukomGrade->portofolio_grade_id = $examGradePortofolio->id;

                            $examGradeMansoskul = new ExamGradeMansoskul();
                            $examGradeMansoskul->exam_type_mansoskul_code = ExamTypesMansoskul::INTEGRITAS->value;
                            $examGradeMansoskul->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeMansoskul->participant_id = $participantUkom->id;
                            $examGradeMansoskul->score = $value[5];
                            $examGradeMansoskul->saveWithUuid();

                            $examGradeMansoskul = new ExamGradeMansoskul();
                            $examGradeMansoskul->exam_type_mansoskul_code = ExamTypesMansoskul::KERJASAMA->value;
                            $examGradeMansoskul->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeMansoskul->participant_id = $participantUkom->id;
                            $examGradeMansoskul->score = $value[6];
                            $examGradeMansoskul->saveWithUuid();

                            $examGradeMansoskul = new ExamGradeMansoskul();
                            $examGradeMansoskul->exam_type_mansoskul_code = ExamTypesMansoskul::KOMUNIKASI->value;
                            $examGradeMansoskul->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeMansoskul->participant_id = $participantUkom->id;
                            $examGradeMansoskul->score = $value[7];
                            $examGradeMansoskul->saveWithUuid();

                            $examGradeMansoskul = new ExamGradeMansoskul();
                            $examGradeMansoskul->exam_type_mansoskul_code = ExamTypesMansoskul::ORIENTASI_HASIL->value;
                            $examGradeMansoskul->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeMansoskul->participant_id = $participantUkom->id;
                            $examGradeMansoskul->score = $value[8];
                            $examGradeMansoskul->saveWithUuid();

                            $examGradeMansoskul = new ExamGradeMansoskul();
                            $examGradeMansoskul->exam_type_mansoskul_code = ExamTypesMansoskul::PELAYANAN_PUBLIK->value;
                            $examGradeMansoskul->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeMansoskul->participant_id = $participantUkom->id;
                            $examGradeMansoskul->score = $value[9];
                            $examGradeMansoskul->saveWithUuid();

                            $examGradeMansoskul = new ExamGradeMansoskul();
                            $examGradeMansoskul->exam_type_mansoskul_code = ExamTypesMansoskul::PENGEMBANGAN_DIRI->value;
                            $examGradeMansoskul->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeMansoskul->participant_id = $participantUkom->id;
                            $examGradeMansoskul->score = $value[10];
                            $examGradeMansoskul->saveWithUuid();

                            $examGradeMansoskul = new ExamGradeMansoskul();
                            $examGradeMansoskul->exam_type_mansoskul_code = ExamTypesMansoskul::MENGELOLA_PERUBAHAN->value;
                            $examGradeMansoskul->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeMansoskul->participant_id = $participantUkom->id;
                            $examGradeMansoskul->score = $value[11];
                            $examGradeMansoskul->saveWithUuid();

                            $examGradeMansoskul = new ExamGradeMansoskul();
                            $examGradeMansoskul->exam_type_mansoskul_code = ExamTypesMansoskul::PENGAMBILAN_KEPUTUSAN->value;
                            $examGradeMansoskul->room_ukom_id = $participantRoomUkom->room_id;
                            $examGradeMansoskul->participant_id = $participantUkom->id;
                            $examGradeMansoskul->score = $value[12];
                            $examGradeMansoskul->saveWithUuid();

                            $ukomGrade->score = $value[13];
                            $ukomGrade->jpm = $value[14];

                            $this->calculate($participantRoomUkom, $ukomGrade, $examGradeCat, $examGradeWawancara, $examGradeSeminar, $examGradePraktik, $examGradePortofolio, $ukomBanService);

                            $participantUkom->inactive_flag = true;
                            $participantUkom->save();
                        } else {
                            Log::warning("UKOM GRADE : participant with nip " . $value[0] . " does not have a room");
                        }
                    } else {
                        Log::warning("UKOM GRADE : participant with nip " . $value[0] . " not found");
                    }
                }
            } finally {
                if (file_exists($file_location_grade)) {
                    unlink($file_location_grade);
                }
            }
        });
    }

    private function calculate(ParticipantRoomUkom $participantRoomUkom, UkomGrade $ukomGrade, ExamGrade $examGradeCat, ExamGrade $examGradeWawancara, ExamGrade $examGradeSeminar, ExamGrade $examGradePraktik, ExamGrade $examGradePortofolio, UkomBanService $ukomBanService)
    {
        $roomUkom = $participantRoomUkom->roomUkom;

        $ukomFormula = UkomFormula::where("jabatan_code", $roomUkom->jabatan_code)
            ->where("jenjang_code", $roomUkom->jenjang_code)
            ->first();

        $ukomGrade->nb_cat = (((float) $examGradeCat->score ?? 0) * (float) $ukomFormula->cat_percentage) / 100;
        $ukomGrade->nb_wawancara = (((float) $examGradeWawancara->score ?? 0) * (float) $ukomFormula->wawancara_percentage) / 100;
        $ukomGrade->nb_seminar = (((float) $examGradeSeminar->score ?? 0) * (float) $ukomFormula->seminar_percentage) / 100;
        $ukomGrade->nb_praktik = (((float) $examGradePraktik->score ?? 0) * (float) $ukomFormula->praktik_percentage) / 100;
        $ukomGrade->nb_portofolio = (((float) $examGradePortofolio->score ?? 0) * (float) $ukomFormula->portofolio_percentage) / 100;

        $ukomGrade->ukt = $ukomGrade->nb_cat + $ukomGrade->nb_wawancara + $ukomGrade->nb_seminar + $ukomGrade->nb_praktik + $ukomGrade->nb_portofolio;
        $ukomGrade->nb_ukt = ((float) $ukomGrade->ukt * (float) $ukomFormula->ukt_percentage) / 100;
        $ukomGrade->ukmsk = ((float) $ukomGrade->score * (float) $ukomFormula->ukmsk_percentage) / 100;
        $ukomGrade->grade = (float) $ukomGrade->ukt + (float) $ukomGrade->ukmsk;

        if (
            (float) $ukomGrade->grade >= (float) $ukomFormula->grade_threshold
            &&
            (float) $ukomGrade->ukt >= (float) $ukomFormula->ukt_threshold
            &&
            (float) $ukomGrade->jpm >= (float) $ukomFormula->jpm_threshold
        ) {
            $ukomGrade->status = 'Lulus Uji Kompetensi';
            $ukomGrade->passed = true;
        } else {
            $ukomGrade->status = 'Tidak Lulus Uji Kompetensi';
            $ukomGrade->passed = false;

            $ukomBanService->banByParticipantId($participantRoomUkom->participant_id);
        }

        $ukomGrade->room_ukom_id = $participantRoomUkom->room_id;
        $ukomGrade->participant_id = $participantRoomUkom->participant_id;

        if ($ukomGrade->id)
            $ukomGrade->save();
        else
            $ukomGrade->saveWithUuid();
    }
}
