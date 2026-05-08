<?php

namespace Eyegil\SijupriUkom\Jobs;

use Carbon\Carbon;
use Eyegil\SijupriMaintenance\Models\SystemConfiguration;
use Eyegil\SijupriUkom\Enums\ExamStatus;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Enums\ExamTypesMansoskul;
use Eyegil\SijupriUkom\Models\ExamGrade;
use Eyegil\SijupriUkom\Models\ExamGradeMansoskul;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Eyegil\SijupriUkom\Models\ParticipantSchedule;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
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

class UkomGradeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 1;

    public $timeout = 1000;

    protected $file_grade;

    protected array $examTypeCodes;

    protected $participantId;

    public function __construct($examTypeCodes = [ExamTypes::CAT->value, ExamTypes::WAWANCARA->value, ExamTypes::MAKALAH->value, ExamTypes::SEMINAR->value, ExamTypes::PORTOFOLIO->value, ExamTypes::PRAKTIK->value, ExamTypes::STUDI_KASUS->value], $participantId = null)
    {
        Log::info("call grading job : " . json_encode($examTypeCodes));
        $this->examTypeCodes = $examTypeCodes;
        $this->participantId = $participantId;
    }

    public function handle(
        ExamGradeService $examGradeService,
        UkomBanService $ukomBanService,
    ) {
        DB::transaction(function () use ($examGradeService, $ukomBanService) {

            Log::info("job ukom grade executing");

            $mainQuery = ParticipantSchedule::with([
                "examSchedule",
                "participantUkom"
            ]);

            if ($this->participantId) {
                $mainQuery->where("participant_id", $this->participantId);
            }

            $participantUkomList = $mainQuery->whereHas("examSchedule", function ($query) {
                $codes = array_diff($this->examTypeCodes, [ExamTypes::CAT->value]);

                if (!empty($codes)) {
                    $query->where(function ($q) use ($codes) {
                        $q->where("exam_type_code", ExamTypes::CAT->value)
                            ->whereHas("examAttendance", function ($q2) {
                                $q2->whereNotNull("finish_at");
                            })
                            ->orWhere(function ($q2) use ($codes) {
                                $q2->whereIn("exam_type_code", $codes)
                                    ->where("end_time", "<", now());
                            });
                    });
                } else {
                    $query->where("exam_type_code", ExamTypes::CAT->value)
                        ->whereHas("examAttendance", function ($q2) {
                            $q2->whereNotNull("finish_at");
                        });
                }
            })
                ->whereHas("examSchedule.roomUkom", function ($query) {
                    $query->where("delete_flag", false)
                        ->where("inactive_flag", false);
                })
                ->get()->each(function (ParticipantSchedule $participantSchedule) use (&$participantUkomKeys, $examGradeService) {
                    try {
                        $examSchedule = $participantSchedule->examSchedule;

                        Log::info("called : " . $examSchedule->exam_type_code);
                        Log::info("participant : " . $participantSchedule->participant_id);

                        if ($examSchedule->exam_type_code == ExamTypes::CAT->value) {
                            $examGradeService->gradeCatByParticipantSchedule($participantSchedule);
                        } else if ($examSchedule->exam_type_code == ExamTypes::WAWANCARA->value) {
                            $examGradeService->gradeWawancaraByParticipantSchedule($participantSchedule);
                        } else if ($examSchedule->exam_type_code == ExamTypes::MAKALAH->value) {
                            $examGradeService->gradeMakalahByParticipantSchedule($participantSchedule);
                        } else if ($examSchedule->exam_type_code == ExamTypes::SEMINAR->value) {
                            $examGradeService->gradeSeminarByParticipantSchedule($participantSchedule);
                        } else if ($examSchedule->exam_type_code == ExamTypes::PORTOFOLIO->value) {
                            $examGradeService->gradePortofolioByParticipantSchedule($participantSchedule);
                        } else if ($examSchedule->exam_type_code == ExamTypes::PRAKTIK->value) {
                            $examGradeService->gradePraktikByParticipantSchedule($participantSchedule);
                        } else if ($examSchedule->exam_type_code == ExamTypes::STUDI_KASUS->value) {
                            $examGradeService->gradeStudiKasusByParticipantSchedule($participantSchedule);
                        }
                    } catch (\Throwable $th) {
                        Log::info("error when grading " . $examSchedule->exam_type_code . " on participant id " . $participantSchedule->participant_id);
                        throw $th;
                    }
                })
                ->pluck('participantUkom')
                ->unique('id')
                ->values();

            foreach ($participantUkomList as $key => $participantUkom) {
                $participantRoomUkom = $participantUkom->participantRoomUkom;

                $ukomGrade = UkomGrade::firstOrNew([
                    'room_ukom_id' => $participantRoomUkom->room_id,
                    'participant_id' => $participantUkom->id,
                ]);

                $this->calculatev2(true, $ukomBanService, $participantRoomUkom, $ukomGrade, ...$this->getExamGrades($participantUkom, $participantRoomUkom, $examGradeService));
            }
        });
    }

    private function calculatev2(bool $isMansoskulSkip, UkomBanService $ukomBanService, ParticipantRoomUkom $participantRoomUkom, UkomGrade $ukomGrade, ?ExamGrade $examGradeCat, ?ExamGrade $examGradeWawancara, ?ExamGrade $examGradeMakalah, ?ExamGrade $examGradeSeminar, ?ExamGrade $examGradePraktik, ?ExamGrade $examGradePortofolio, ?ExamGrade $examGradeStudiKasus)
    {
        $roomUkom = $participantRoomUkom->roomUkom;

        $ukomFormula = UkomFormula::where("jabatan_code", $roomUkom->jabatan_code)
            ->where("jenjang_code", $roomUkom->jenjang_code)
            ->first();

        if ($examGradeCat) {
            $ukomGrade->cat_grade_id = $examGradeCat->id;
            if ($examGradeCat->score != null) {
                $ukomGrade->nb_cat = (((float) $examGradeCat->score ?? 0) * (float) $ukomFormula->cat_percentage) / 100;
            }
        } else
            $ukomGrade->nb_cat = null;

        if ($examGradeWawancara) {
            $ukomGrade->wawancara_grade_id = $examGradeWawancara->id;
            if ($examGradeWawancara->score != null) {
                $ukomGrade->nb_wawancara = (((float) $examGradeWawancara->score ?? 0) * (float) $ukomFormula->wawancara_percentage) / 100;
            }
        } else
            $ukomGrade->nb_wawancara = null;

        if ($examGradeSeminar && $examGradeMakalah) {
            $ukomGrade->makalah_grade_id = $examGradeMakalah->id;
            $ukomGrade->seminar_grade_id = $examGradeSeminar->id;
            if ($examGradeMakalah->score != null && $examGradeSeminar->score != null) {
                $ukomGrade->nb_seminar = ((((float) $examGradeSeminar->score ?? 0) + ((float) $examGradeMakalah->score ?? 0)) * (float) $ukomFormula->seminar_percentage) / 100;
            }
        } else
            $ukomGrade->nb_seminar = null;

        if ($examGradePraktik) {
            $ukomGrade->praktik_grade_id = $examGradePraktik->id;
            if ($examGradePraktik->score != null) {
                $ukomGrade->nb_praktik = (((float) $examGradePraktik->score ?? 0) * (float) $ukomFormula->praktik_percentage) / 100;
            }
        } else
            $ukomGrade->nb_praktik = null;

        if ($examGradePortofolio) {
            $ukomGrade->portofolio_grade_id = $examGradePortofolio->id;
            if ($examGradePortofolio->score != null) {
                $ukomGrade->nb_portofolio = (((float) $examGradePortofolio->score ?? 0) * (float) $ukomFormula->portofolio_percentage) / 100;
            }
        } else
            $ukomGrade->nb_portofolio = null;

        if ($examGradeStudiKasus) {
            $ukomGrade->studi_kasus_grade_id = $examGradeStudiKasus->id;
            if ($examGradeStudiKasus->score != null) {
                $ukomGrade->nb_studi_kasus = (((float) $examGradeStudiKasus->score ?? 0) * (float) $ukomFormula->studi_kasus_percentage) / 100;
            }
        } else
            $ukomGrade->nb_studi_kasus = null;

        Log::debug("examCat: " . $ukomGrade->nb_cat);
        Log::debug("examWawancara: " . $ukomGrade->nb_wawancara);
        Log::debug("examSeminar: " . $ukomGrade->nb_seminar);
        Log::debug("examPraktik: " . $ukomGrade->nb_praktik);
        Log::debug("examPortofolio: " . $ukomGrade->nb_portofolio);

        $ukomGrade->ukt = ($ukomGrade->nb_cat ?? 0) + ($ukomGrade->nb_wawancara ?? 0) + ($ukomGrade->nb_seminar ?? 0) + ($ukomGrade->nb_praktik ?? 0) + ($ukomGrade->nb_portofolio ?? 0);
        Log::debug("ukt: " . $ukomGrade->ukt);
        $ukomGrade->nb_ukt = ((float) $ukomGrade->ukt * (float) $ukomFormula->ukt_percentage) / 100;

        if (!$isMansoskulSkip) {
            $ukomGrade->ukmsk = ((float) $ukomGrade->jpm * (float) $ukomFormula->ukmsk_percentage) / 100;
            $ukomGrade->grade = (float) $ukomGrade->nb_ukt + (float) $ukomGrade->ukmsk;

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
            }
        } else {
            $ukomGrade->grade = $ukomGrade->ukt;
            if (
                // (float) $ukomGrade->grade >= (float) $ukomFormula->grade_threshold
                // &&
                (float) $ukomGrade->ukt >= (float) $ukomFormula->ukt_threshold
            ) {
                $ukomGrade->status = 'Lulus Uji Kompetensi';
                $ukomGrade->passed = true;
            } else {
                $ukomGrade->status = 'Tidak Lulus Uji Kompetensi';
                $ukomGrade->passed = false;
            }
        }

        $ukomGrade->room_ukom_id = $participantRoomUkom->room_id;
        $ukomGrade->participant_id = $participantRoomUkom->participant_id;

        if ($ukomGrade->id)
            $ukomGrade->save();
        else
            $ukomGrade->saveWithUuid();
    }

    public function handleOld(
        ParticipantUkomService $participantUkomService,
        ExamGradeService $examGradeService,
        StorageService $storageService,
        StorageSystemService $storageSystemService,
        UkomBanService $ukomBanService,
    ): void {
        DB::transaction(function () use ($participantUkomService, $examGradeService, $storageService, $storageSystemService, $ukomBanService) {
            $objectName = $storageService->putObjectFromBase64WithFilename(
                "system",
                "ukom",
                "grade_" . now()->format('YmdHis'),
                $this->file_grade
            );
            $filePath = storage_path('app/' . $storageSystemService->getFileLocation("ukom", $objectName));

            try {
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = [];
                foreach ($sheet->getRowIterator() as $row) {
                    $rowData = [];
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    foreach ($cellIterator as $cell) {
                        $rowData[] = $cell->getValue();
                    }
                    $rows[] = $rowData;
                }

                $sysConf = SystemConfiguration::findOrThrowNotFound("UKOM_GRADE_IS_REPLACE");
                $sysCnfValue = json_decode($sysConf->value, true);

                foreach ($rows as $index => $values) {
                    if ($index === 0)
                        continue; // skip header

                    $nipOrEmail = $values[0];
                    Log::info("Processing participant: $nipOrEmail");

                    $participant = $participantUkomService->findByNipOrEmailLatest($nipOrEmail);
                    if (!$participant) {
                        Log::warning("Participant not found: $nipOrEmail");
                        continue;
                    }

                    $participantRoomUkom = $participant->participantRoomUkom;
                    if (!$participantRoomUkom) {
                        Log::warning("No room assigned for participant: $nipOrEmail");
                        continue;
                    }

                    $ukomGrade = UkomGrade::firstOrNew([
                        'room_ukom_id' => $participantRoomUkom->room_id,
                        'participant_id' => $participant->id,
                    ]);

                    $this->processExamGrade($values, $sysCnfValue, $examGradeService, $participantRoomUkom, $participant, $ukomGrade);

                    $isMansoskulSkip = false;
                    $this->processMansoskulGrades($values, $participantRoomUkom, $participant, $isMansoskulSkip);

                    $ukomGrade->score = $isMansoskulSkip ? null : $values[15];
                    $ukomGrade->jpm = $isMansoskulSkip ? null : $values[16];

                    $this->calculate($isMansoskulSkip, $ukomBanService, $participantRoomUkom, $ukomGrade, ...$this->getExamGrades($participant, $participantRoomUkom, $examGradeService));
                    $participant->save();
                }
            } finally {
                if (file_exists($filePath))
                    unlink($filePath);
            }
        });
    }

    private function processExamGrade($scores, array $sysCnfValue, ExamGradeService $examGradeService, ParticipantRoomUkom $participantRoomUkom, ParticipantUkom $participant, UkomGrade &$ukomGrade): void
    {
        $examTypes = [
            ExamTypes::CAT->value => 1,
            ExamTypes::WAWANCARA->value => 2,
            ExamTypes::SEMINAR->value => 3,
            ExamTypes::PRAKTIK->value => 4,
            ExamTypes::PORTOFOLIO->value => 5,
            ExamTypes::STUDI_KASUS->value => 6,
        ];

        foreach ($examTypes as $type => $index) {
            $grade = null;
            $isOldData = false;
            if ($participant->delete_flag || $participant->inactive_flag) {
                $grade = $examGradeService->findByExamTypeCodeAndParticipantIdAndFlaggedFalse(
                    $type,
                    $participant->id
                );
                if ($participantRoomUkom->room_id != $grade->room_ukom_id) {
                    $isOldData = true;
                }
            } else {
                $grade = $examGradeService->findByExamTypeCodeAndRoomUkomIdParticipantNipAndFlaggedFalse(
                    $type,
                    $participantRoomUkom->room_id,
                    $participant->id
                );
            }

            if ($sysCnfValue[$type] === "ya" && isset($scores[$index]) && is_numeric($scores[$index])) {
                $score = isset($scores[$index]) ? (trim($scores[$index]) == '-' ? null : $scores[$index]) : 0;

                if (!$isOldData) {
                    if ($grade) {
                        $grade->fromArray([
                            'exam_type_code' => $type,
                            'room_ukom_id' => $participantRoomUkom->room_id,
                            'participant_id' => $participant->id,
                            'score' => $score
                        ]);
                        $grade->save();
                    } else {
                        $grade = new ExamGrade();
                        $grade->fromArray([
                            'exam_type_code' => $type,
                            'room_ukom_id' => $participantRoomUkom->room_id,
                            'participant_id' => $participant->id,
                            'score' => $score
                        ]);
                        $grade->saveWithUuid();
                    }
                } else {
                    $newGrade = new ExamGrade();
                    $newGrade->fromArray([
                        'exam_type_code' => $type,
                        'room_ukom_id' => $participantRoomUkom->room_id,
                        'participant_id' => $participant->id,
                        'score' => $score ?? $grade->score ?? 0,
                    ]);
                }
            } else {
                if (!$grade) {
                    Log::warning("Participant has not completed {$type}");
                    return;
                }
            }

            $field = strtolower($type) . '_grade_id';
            $ukomGrade->$field = $grade->id ?? null;
        }
    }

    private function processMansoskulGrades(array $values, $participantRoomUkom, $participant, &$isMansoskulSkip): void
    {
        $mansoskulTypes = [
            ExamTypesMansoskul::INTEGRITAS->value,
            ExamTypesMansoskul::KERJASAMA->value,
            ExamTypesMansoskul::KOMUNIKASI->value,
            ExamTypesMansoskul::ORIENTASI_HASIL->value,
            ExamTypesMansoskul::PELAYANAN_PUBLIK->value,
            ExamTypesMansoskul::PENGEMBANGAN_DIRI->value,
            ExamTypesMansoskul::MENGELOLA_PERUBAHAN->value,
            ExamTypesMansoskul::PENGAMBILAN_KEPUTUSAN->value,
            ExamTypesMansoskul::PEREKAT_BANGSA->value,
        ];


        foreach ($mansoskulTypes as $i => $type) {
            $score = isset($values[6 + $i]) ? (trim($values[6 + $i]) == '-' ? null : $values[6 + $i]) : 0;
            if ($score === null) {
                $isMansoskulSkip = true;
            }
        }

        foreach ($mansoskulTypes as $i => $type) {
            $score = isset($values[6 + $i]) ? (trim($values[6 + $i]) == '-' ? null : $values[6 + $i]) : 0;

            $grade = new ExamGradeMansoskul();
            $grade->fromArray([
                'exam_type_mansoskul_code' => $type,
                'room_ukom_id' => $participantRoomUkom->room_id,
                'participant_id' => $participant->id,
                'score' => $isMansoskulSkip ? null : $score,
            ]);
            $grade->saveWithUuid();
        }
    }

    private function getExamGrades($participant, $participantRoomUkom, ExamGradeService $examGradeService): array
    {
        return array_map(
            fn($type) => $examGradeService->findByExamTypeCodeAndRoomUkomIdParticipantNipLatest(
                $type,
                $participantRoomUkom->room_id,
                $participant->nip
            ),
            [
                ExamTypes::CAT->value,
                ExamTypes::WAWANCARA->value,
                ExamTypes::MAKALAH->value,
                ExamTypes::SEMINAR->value,
                ExamTypes::PRAKTIK->value,
                ExamTypes::PORTOFOLIO->value,
                ExamTypes::STUDI_KASUS->value,
            ]
        );
    }

    private function calculate(bool $isMansoskulSkip, UkomBanService $ukomBanService, ParticipantRoomUkom $participantRoomUkom, UkomGrade $ukomGrade, ?ExamGrade $examGradeCat, ?ExamGrade $examGradeWawancara, ?ExamGrade $examGradeSeminar, ?ExamGrade $examGradePraktik, ?ExamGrade $examGradePortofolio)
    {
        $roomUkom = $participantRoomUkom->roomUkom;

        $ukomFormula = UkomFormula::where("jabatan_code", $roomUkom->jabatan_code)
            ->where("jenjang_code", $roomUkom->jenjang_code)
            ->first();

        if ($examGradeCat && $examGradeCat->score)
            $ukomGrade->nb_cat = (((float) $examGradeCat->score ?? 0) * (float) $ukomFormula->cat_percentage) / 100;
        else
            $ukomGrade->nb_cat = null;

        if ($examGradeWawancara && $examGradeWawancara->score)
            $ukomGrade->nb_wawancara = (((float) $examGradeWawancara->score ?? 0) * (float) $ukomFormula->wawancara_percentage) / 100;
        else
            $ukomGrade->nb_wawancara = null;

        if ($examGradeSeminar && $examGradeSeminar->score)
            $ukomGrade->nb_seminar = (((float) $examGradeSeminar->score ?? 0) * (float) $ukomFormula->seminar_percentage) / 100;
        else
            $ukomGrade->nb_seminar = null;

        if ($examGradePraktik && $examGradePraktik->score)
            $ukomGrade->nb_praktik = (((float) $examGradePraktik->score ?? 0) * (float) $ukomFormula->praktik_percentage) / 100;
        else
            $ukomGrade->nb_praktik = null;

        if ($examGradePortofolio && $examGradePortofolio->score)
            $ukomGrade->nb_portofolio = (((float) $examGradePortofolio->score ?? 0) * (float) $ukomFormula->portofolio_percentage) / 100;
        else
            $ukomGrade->nb_portofolio = null;

        Log::info("examCat: " . $ukomGrade->nb_cat);
        Log::info("examWawancara: " . $ukomGrade->nb_wawancara);
        Log::info("examSeminar: " . $ukomGrade->nb_seminar);
        Log::info("examPraktik: " . $ukomGrade->nb_praktik);
        Log::info("examPortofolio: " . $ukomGrade->nb_portofolio);

        $ukomGrade->ukt = ($ukomGrade->nb_cat ?? 0) + ($ukomGrade->nb_wawancara ?? 0) + ($ukomGrade->nb_seminar ?? 0) + ($ukomGrade->nb_praktik ?? 0) + ($ukomGrade->nb_portofolio ?? 0);
        Log::info("ukt: " . $ukomGrade->ukt);
        $ukomGrade->nb_ukt = ((float) $ukomGrade->ukt * (float) $ukomFormula->ukt_percentage) / 100;

        if (!$isMansoskulSkip) {
            $ukomGrade->ukmsk = ((float) $ukomGrade->jpm * (float) $ukomFormula->ukmsk_percentage) / 100;
            $ukomGrade->grade = (float) $ukomGrade->nb_ukt + (float) $ukomGrade->ukmsk;

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
            }
        } else {
            $ukomGrade->grade = $ukomGrade->ukt;
            if (
                // (float) $ukomGrade->grade >= (float) $ukomFormula->grade_threshold
                // &&
                (float) $ukomGrade->ukt >= (float) $ukomFormula->ukt_threshold
            ) {
                $ukomGrade->status = 'Lulus Uji Kompetensi';
                $ukomGrade->passed = true;
            } else {
                $ukomGrade->status = 'Tidak Lulus Uji Kompetensi';
                $ukomGrade->passed = false;
            }
        }

        $ukomGrade->room_ukom_id = $participantRoomUkom->room_id;
        $ukomGrade->participant_id = $participantRoomUkom->participant_id;

        if ($ukomGrade->id)
            $ukomGrade->save();
        else
            $ukomGrade->saveWithUuid();
    }
}
