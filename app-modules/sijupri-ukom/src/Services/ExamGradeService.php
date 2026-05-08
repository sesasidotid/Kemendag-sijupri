<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\EyegilLms\Dtos\MultipleChoiceDto;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Enums\QuestionType;
use Eyegil\EyegilLms\Models\Answer;
use Eyegil\EyegilLms\Models\MultipleChoice;
use Eyegil\EyegilLms\Services\AnswerService;
use Eyegil\SijupriMaintenance\Dtos\KompetensiIndikatorDto;
use Eyegil\SijupriMaintenance\Services\KompetensiIndikatorService;
use Eyegil\SijupriMaintenance\Services\KompetensiService;
use Eyegil\SijupriUkom\Dtos\ExamGradeDto;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Jobs\UkomGradeJob;
use Eyegil\SijupriUkom\Models\ExamAttendance;
use Eyegil\SijupriUkom\Models\ExamGrade;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Eyegil\SijupriUkom\Models\ParticipantSchedule;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Support\Facades\DB;
use Eyegil\SijupriUkom\Models\UkomGrade;

class ExamGradeService
{

    public function __construct(
        private KompetensiService $kompetensiService,
        private KompetensiIndikatorService $kompetensiIndikatorService,
        private StorageService $storageService,
        private StorageSystemService $storageSystemService,
        private AnswerService $answerService,
        private ExamQuestionService $examQuestionService,
        private ParticipantUkomService $participantUkomService,
        private ExamAttendanceService $examAttendanceService,
    ) {
    }

    public function findById($id)
    {
        return ExamGrade::findOrThrowNotFound($id);
    }

    public function findByExamScheduleIdAndParticipantId($exam_schedule_id, $participant_id)
    {
        return ExamGrade::where("exam_schedule_id", $exam_schedule_id)
            ->where("participant_id", $participant_id)
            ->first();
    }

    public function findByExamScheduleIdAndParticipantNip($exam_schedule_id, $nip)
    {
        return ExamGrade::where("exam_schedule_id", $exam_schedule_id)
            ->whereHas("participant", function ($query) use ($nip) {
                $query->where("nip", $nip);
            })
            ->latest("date_created")
            ->first();
    }


    public function findByExamTypeCodeAndParticipantIdAndFlaggedFalse($exam_type_code, $participant_id)
    {
        return ExamGrade::whereHas("examSchedule", function ($query) use ($exam_type_code) {
            $query->where("exam_type_code", $exam_type_code);
        })
            ->where("participant_id", $participant_id)
            ->where("inactive_flag", false)
            ->where("delete_flag", false)
            ->firstOrThrowNotFound();
    }

    public function findByExamTypeCodeAndRoomUkomIdParticipantNipAndFlaggedFalse($exam_type_code, $room_ukom_id, $nip)
    {
        return ExamGrade::whereHas("examSchedule", function ($query) use ($exam_type_code, $room_ukom_id) {
            $query->where("exam_type_code", $exam_type_code)
                ->where("room_ukom_id", $room_ukom_id);
        })->whereHas("participant", function ($query) use ($nip) {
            $query->where("nip", $nip);
        })->where("inactive_flag", false)
            ->where("delete_flag", false)
            ->firstOrThrowNotFound();
    }

    public function findByExamTypeCodeAndRoomUkomIdParticipantNipLatest($exam_type_code, $room_ukom_id, $nip)
    {
        return ExamGrade::whereHas("examSchedule", function ($query) use ($exam_type_code, $room_ukom_id) {
            $query->where("exam_type_code", $exam_type_code)
                ->where("room_ukom_id", $room_ukom_id);
        })->whereHas("participant", function ($query) use ($nip) {
            $query->where("nip", $nip);
        })->where("inactive_flag", false)
            ->where("delete_flag", false)
            ->latest("date_created")
            ->first();
    }

    // this one allowed
    public function findGradeByExamTypeCodeAndParticipantIdLatest($exam_type_code, $participant_id)
    {
        $examGrade = ExamGrade::whereHas("examSchedule", function ($query) use ($exam_type_code) {
            $query->where("exam_type_code", $exam_type_code)
                ->latest("date_created");
        })->where("participant_id", $participant_id)
            ->whereHas("participant", function ($query) {
                $query->where(function ($q) {
                    $q->where('date_created', '<=', Carbon::parse('2026-01-01 00:00:00'))
                        ->orWhere(function ($q2) {
                            $q2->where('date_created', '>', Carbon::parse('2026-01-01 00:00:00'))
                                ->where('grade_visibility', true);
                        });
                });
            })
            ->firstOrThrowNotFound();

        $examGradeDto = (new ExamGradeDto())->fromModel($examGrade);
        $tempKompetensiIndikator = [];

        $examQuestionList = ExamQuestion::where("participant_id", operator: $participant_id)
            ->where('exam_schedule_id', $examGrade->exam_schedule_id)
            ->get();

        if ($examGrade->examSchedule->exam_type_code == ExamTypes::CAT->name) {
            foreach ($examQuestionList as $examQuestion) {
                $questionGroup = $examQuestion->questionGroup;

                if ($questionGroup) {
                    $question = $examQuestion->question;

                    $questionDto = (new QuestionDto())->fromModel($question);
                    if ($question->attachment) {
                        $questionDto->attachment_url = $this->storageService->getUrl("system", "lms", $question->attachment);
                    }

                    // Map multiple choices without 'correct' field
                    if ($question->choices) {
                        $questionDto->multiple_choice_dto_list = $question->choices->map(function (MultipleChoice $multipleChoice) {
                            return (new MultipleChoiceDto())->fromModel($multipleChoice);
                        });
                    }

                    // Fetch answer efficiently
                    $answer = $this->answerService->findByQuestionIdAndParticipantId($question->id, $participant_id);
                    if ($answer) {
                        $questionDto->answer_dto = (new AnswerDto())->fromModel($answer);
                    }

                    // Avoid unnecessary queries: Fetch `kompetensi` in batch if possible
                    if (!isset($tempKompetensiIndikator[$questionGroup->association_id])) {
                        $kompetensiIndikator = $this->kompetensiIndikatorService->findById($questionGroup->association_id);
                        $kompetensiIndikatorDto = (new KompetensiIndikatorDto())->fromModel($kompetensiIndikator);
                        $kompetensiIndikatorDto->kompetensi_name = $kompetensiIndikator->kompetensi->name;
                        $kompetensiIndikatorDto->question_dto_list = [$questionDto];

                        $tempKompetensiIndikator[$questionGroup->association_id] = $kompetensiIndikatorDto;
                    } else {
                        $tempKompetensiIndikator[$questionGroup->association_id]->question_dto_list[] = $questionDto;
                    }
                }
            }

            $examGradeDto->kompetensi_indikator_dto_list = array_values($tempKompetensiIndikator);
        } else {
            $examGradeDto->question_dto_list = [];
            foreach ($examQuestionList as $examQuestion) {
                $question = $examQuestion->question;

                $questionDto = (new QuestionDto())->fromModel($question);
                if ($question->attachment) {
                    $questionDto->attachment_url = $this->storageService->getUrl("system", "lms", $question->attachment);
                }

                // Fetch answer efficiently
                $answer = $this->answerService->findByQuestionIdAndParticipantId($question->id, $participant_id);
                if ($answer) {
                    $questionDto->answer_dto = (new AnswerDto())->fromModel($answer);
                    if ($questionDto->answer_dto->answer_upload) {
                        $questionDto->answer_dto->answer_upload_url = $this->storageService->getUrl("system", "lms", $questionDto->answer_dto->answer_upload);
                    }
                }

                $examGradeDto->question_dto_list[] = $questionDto;
            }
        }

        return $examGradeDto;
    }

    public function findGradeByExamScheduleIdAndParticipantId($exam_schedule_id, $participant_id, $isJf = false)
    {
        $examGrade = null;
        $userContext = user_context();
        $isAdmin = ((optional($userContext)->application_code ?? "") == "sijupri-admin");

        if ($isAdmin) {
            $examGrade = ExamGrade::where("exam_schedule_id", $exam_schedule_id)
                ->where("participant_id", $participant_id)
                ->firstOrThrowNotFound();
        } else {
            $examSchedule = ExamSchedule::with("examScheduleChild")->findOrThrowNotFound($exam_schedule_id);
            if ($examSchedule->exam_type_code == ExamTypes::CAT->value) {
                $examGrade = ExamGrade::where("exam_schedule_id", $exam_schedule_id)
                    ->where("participant_id", $participant_id)
                    ->firstOrThrowNotFound();
            } else {
                $examGrade = ExamGrade::where("exam_schedule_id", $exam_schedule_id)
                    ->where("participant_id", $participant_id)
                    ->whereHas("participant", function ($query) {
                        $query->where('grade_visibility', true);
                    })->firstOrThrowNotFound();
            }
        }

        $examGradeDto = new ExamGradeDto();
        if ($examGrade) {
            $examGradeDto->fromModel($examGrade);
            $examGradeDto->exam_schedule_id = $exam_schedule_id;
            $examGradeDto->exam_type_code = $examGrade->examSchedule->exam_type_code;
            $examGradeDto->room_ukom_id = $examGrade->examSchedule->room_ukom_id;
            $tempKompetensiIndikator = [];

            $examQuestionList = ExamQuestion::with("question.answer")
                ->where('exam_schedule_id', $exam_schedule_id)
                ->where('participant_ukom_id', $participant_id)
                ->get();

            if ($examGrade->examSchedule->exam_type_code == ExamTypes::CAT->name) {

                foreach ($examQuestionList as $examQuestion) {
                    $questionGroup = $examQuestion->questionGroup;

                    if ($questionGroup) {
                        $question = $examQuestion->question;

                        $questionDto = (new QuestionDto())->fromModel($question);
                        if ($question->attachment) {
                            $questionDto->attachment_url = $this->storageService->getUrl("system", "lms", $question->attachment);
                        }

                        // Map multiple choices without 'correct' field
                        if ($question->choices) {
                            $questionDto->multiple_choice_dto_list = $question->choices->map(function (MultipleChoice $multipleChoice) {
                                return (new MultipleChoiceDto())->fromModel($multipleChoice);
                            });
                        }

                        // Fetch answer efficiently
                        $answer = $examQuestion->answer;
                        if ($answer) {
                            $questionDto->answer_dto = (new AnswerDto())->fromModel($answer);
                        }

                        // Avoid unnecessary queries: Fetch `kompetensi` in batch if possible
                        if (!isset($tempKompetensiIndikator[$questionGroup->association_id])) {
                            $kompetensiIndikator = $this->kompetensiIndikatorService->findById($questionGroup->association_id);
                            $kompetensiIndikatorDto = (new KompetensiIndikatorDto())->fromModel($kompetensiIndikator);
                            $kompetensiIndikatorDto->kompetensi_name = $kompetensiIndikator->kompetensi->name;
                            $kompetensiIndikatorDto->question_dto_list = [$questionDto];

                            $tempKompetensiIndikator[$questionGroup->association_id] = $kompetensiIndikatorDto;
                        } else {
                            $tempKompetensiIndikator[$questionGroup->association_id]->question_dto_list[] = $questionDto;
                        }
                    }
                }

                $examGradeDto->kompetensi_indikator_dto_list = array_values($tempKompetensiIndikator);
            } else {
                $examGradeDto->question_dto_list = [];
                foreach ($examQuestionList as $examQuestion) {
                    $question = $examQuestion->question;

                    $questionDto = (new QuestionDto())->fromModel($question);
                    if ($question->attachment) {
                        $questionDto->attachment_url = $this->storageService->getUrl("system", "lms", $question->attachment);
                    }

                    // Fetch answer efficiently
                    $answer = $this->answerService->findByQuestionIdAndParticipantId($question->id, $participant_id);
                    if ($answer) {
                        $questionDto->answer_dto = (new AnswerDto())->fromModel($answer);
                        if ($questionDto->answer_dto->answer_upload) {
                            $questionDto->answer_dto->answer_upload_url = $this->storageService->getUrl("system", "lms", $questionDto->answer_dto->answer_upload);
                        }
                    }

                    $examGradeDto->question_dto_list[] = $questionDto;
                }
            }
        }

        return $examGradeDto;
    }

    public function downloadTemplate()
    {
        return $this->storageSystemService->downloadFile("template", "template_grade.xlsx");
    }

    public function gradeExam()
    {
        DB::transaction(function () {
            $examAttendanceList = ExamAttendance::whereNull("finish_at")->get();
            foreach ($examAttendanceList as $examAttendance) {
                $examSchedule = $examAttendance->examSchedule;

                if ($examSchedule->duration) {
                    if (Carbon::parse($examAttendance->start_at)->diffInHours(Carbon::now()) >= $examSchedule->duration) {
                        $examAttendance->finish_at = Carbon::now();
                        $examAttendance->save();
                    }
                } else if (Carbon::now()->isAfter(Carbon::parse($examSchedule->end_time))) {
                    $examAttendance->finish_at = Carbon::now();
                    $examAttendance->save();
                }
            }

            $examScheduleList = ExamSchedule::whereHas("roomUkom", function ($query) {
                $query->where("delete_flag", false)
                    ->where("inactive_flag", false);
            })->where("exam_type_code", ExamTypes::CAT->name)
                ->get();
            foreach ($examScheduleList as $examSchedule) {
                foreach ($examSchedule->participantScheduleList as $key => $participantSchedule) {
                    $examAttendance = ExamAttendance::where("exam_schedule_id", $participantSchedule->exam_schedule_id)
                        ->where("participant_ukom_id", $participantSchedule->participant_id)
                        ->first();

                    if ($examAttendance->finish_at != null) {
                        if ($examSchedule->exam_type_code == ExamTypes::CAT->name) {
                            UkomGradeJob::dispatch([ExamTypes::CAT->value], $participantSchedule->participant_id);
                        }
                    }
                }
            }
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $examGrade = $this->findById($id);
            $examSchedule = $examGrade->examSchedule;

            $examAttendance = $this->examAttendanceService->findByExamScheduleIdAndParticipantId(
                $examGrade->exam_schedule_id,
                $examGrade->participant_id
            );

            ExamQuestion::where("participant_ukom_id", $examGrade->participant_id)->where("exam_schedule_id", $examSchedule->id)->each(function (ExamQuestion $examQuestion) {
                Answer::where("id", $examQuestion->answer_id)->delete();
                $examQuestion->delete();
            });

            $ukomGrade = UkomGrade::where("room_ukom_id", $examSchedule->room_ukom_id)->where("participant_id", $examGrade->participant_id)->first();

            if ($ukomGrade) {
                $types = [];
                if ($ukomGrade->cat_grade_id != null) {
                    $types[] = ExamTypes::CAT->value;
                }
                if ($ukomGrade->wawancara_grade_id != null) {
                    $types[] = ExamTypes::WAWANCARA->value;
                }
                if ($ukomGrade->seminar_grade_id != null) {
                    $types[] = ExamTypes::MAKALAH->value;
                    $types[] = ExamTypes::SEMINAR->value;
                }
                if ($ukomGrade->praktik_grade_id != null) {
                    $types[] = ExamTypes::PRAKTIK->value;
                }
                if ($ukomGrade->portofolio_grade_id != null) {
                    $types[] = ExamTypes::PORTOFOLIO->value;
                }
                if ($ukomGrade->studi_kasus_grade_id != null) {
                    $types[] = ExamTypes::STUDI_KASUS->value;
                }
                $ukomGrade->delete();

                UkomGradeJob::dispatch($types);
            }

            if ($examAttendance)
                $examAttendance->delete();
            $examGrade->delete();
        });
    }

    public function gradeAllExams()
    {
        UkomGradeJob::dispatch();
    }


    public function gradeCatByParticipantSchedule(ParticipantSchedule $participantSchedule)
    {
        DB::transaction(function () use ($participantSchedule) {
            $isExist = ExamGrade::where("exam_schedule_id", $participantSchedule->exam_schedule_id)
                ->where("participant_id", $participantSchedule->participant_id)
                ->exists();
            if ($isExist) {
                return;
            }

            $examQuestionList = $participantSchedule->examQuestionList($participantSchedule->participant_id);
            $questionCount = count($examQuestionList);

            $score = 0;
            $correctCount = 0;
            if ($questionCount > 0) {
                foreach ($examQuestionList as $examQuestion) {
                    $question = $examQuestion->question;
                    $choices = $question->choices;
                    $answer = $examQuestion->answer;
                    if ($answer) {
                        foreach ($choices as $choice) {
                            if (trim(strtolower($choice->choice_id)) === trim(strtolower($answer->answer_choice ?? ''))) {
                                if ($choice->correct) {
                                    $correctCount++;
                                }
                                break;
                            }
                        }
                    } else {
                        $answerDto = new AnswerDto();
                        $answerDto->answer_choice = null;
                        $answerDto->participant_id = $participantSchedule->participant_id;
                        $answerDto->question_id = $question->id;
                        $answerDto->question_type = QuestionType::MULTI_CHOICE->value;
                        $this->answerService->save($answerDto);
                    }
                }
            }

            $score = ($questionCount > 0) ? ($correctCount / $questionCount) * 100 : 0;

            ExamGrade::where("participant_id", $participantSchedule->participant_id)
                ->update(["inactive_flag" => true]);

            $examGrade = new ExamGrade();
            $examGrade->exam_schedule_id = $participantSchedule->exam_schedule_id;
            $examGrade->participant_id = $participantSchedule->participant_id;
            $examGrade->score = $score ?? 0;
            $examGrade->saveWithUUid();
        });
    }

    public function gradeMakalahByParticipantSchedule(ParticipantSchedule $participantSchedule)
    {
        DB::transaction(function () use ($participantSchedule) {
            $isExist = ExamGrade::where("exam_schedule_id", $participantSchedule->exam_schedule_id)
                ->where("participant_id", $participantSchedule->participant_id)
                ->exists();
            if ($isExist) {
                return;
            }

            $examQuestionList = $participantSchedule->examQuestionList($participantSchedule->participant_id);

            $score = 0;
            foreach ($examQuestionList as $examQuestion) {
                if ($examQuestion->id == "base_makalah_question") {
                    continue;
                }
                $question = $examQuestion->question;
                $answer = $examQuestion->answer;

                if ($answer) {
                    $score += min($answer->score, $question->weight);
                }
            }

            $examGrade = new ExamGrade();
            $examGrade->exam_schedule_id = $participantSchedule->exam_schedule_id;
            $examGrade->participant_id = $participantSchedule->participant_id;
            $examGrade->score = $score ?? 0;
            $examGrade->saveWithUUid();
        });
    }

    public function gradeSeminarByParticipantSchedule(ParticipantSchedule $participantSchedule)
    {
        DB::transaction(function () use ($participantSchedule) {
            $isExist = ExamGrade::where("exam_schedule_id", $participantSchedule->exam_schedule_id)
                ->where("participant_id", $participantSchedule->participant_id)
                ->exists();
            if ($isExist) {
                return;
            }

            $examQuestionList = $participantSchedule->examQuestionList($participantSchedule->participant_id);

            $score = 0;
            foreach ($examQuestionList as $examQuestion) {
                if ($examQuestion->id == "base_makalah_question") {
                    continue;
                }
                $question = $examQuestion->question;
                $answer = $examQuestion->answer;

                if ($answer) {
                    $score += min($answer->score, $question->weight);
                }
            }

            $examGrade = new ExamGrade();
            $examGrade->exam_schedule_id = $participantSchedule->exam_schedule_id;
            $examGrade->participant_id = $participantSchedule->participant_id;
            $examGrade->score = $score ?? 0;
            $examGrade->saveWithUUid();
        });
    }

    public function gradeWawancaraByParticipantSchedule(ParticipantSchedule $participantSchedule)
    {
        DB::transaction(function () use ($participantSchedule) {
            $isExist = ExamGrade::where("exam_schedule_id", $participantSchedule->exam_schedule_id)
                ->where("participant_id", $participantSchedule->participant_id)
                ->exists();
            if ($isExist) {
                return;
            }

            $examQuestionList = $participantSchedule->examQuestionList($participantSchedule->participant_id);

            $score = 0;
            foreach ($examQuestionList as $examQuestion) {
                $question = $examQuestion->question;
                $choices = $question->choices;
                $answer = $examQuestion->answer;

                if ($answer) {
                    foreach ($choices as $choice) {
                        if (strtolower($choice->choice_id) == strtolower($answer->answer_choice)) {
                            if ($choice->correct)
                                $score += $question->weight ?? 0;
                            break;
                        }
                    }
                }
            }

            $examGrade = new ExamGrade();
            $examGrade->exam_schedule_id = $participantSchedule->exam_schedule_id;
            $examGrade->participant_id = $participantSchedule->participant_id;
            $examGrade->score = $score ?? 0;
            $examGrade->saveWithUUid();
        });
    }

    public function gradePortofolioByParticipantSchedule(ParticipantSchedule $participantSchedule)
    {
        DB::transaction(function () use ($participantSchedule) {
            $isExist = ExamGrade::where("exam_schedule_id", $participantSchedule->exam_schedule_id)
                ->where("participant_id", $participantSchedule->participant_id)
                ->exists();
            if ($isExist) {
                return;
            }

            $examQuestionList = $participantSchedule->examQuestionList($participantSchedule->participant_id);

            $score = 0;
            foreach ($examQuestionList as $examQuestion) {
                $question = $examQuestion->question;
                $checkList = $question->checkList;
                $answer = $examQuestion->answer;

                if ($answer) {
                    $answer_list = [];
                    if (is_string($answer->answer_list)) {
                        $answer_list = json_decode($answer->answer_list, true);
                    } else if (is_object($answer->answer_list)) {
                        $answer_list = (array) $answer->answer_list;
                    } else if (is_array($answer->answer_list)) {
                        $answer_list = $answer->answer_list;
                    } else {
                        continue;
                    }

                    $checklistCount = $checkList->count();
                    $checkedCount = 0;
                    foreach ($checkList as $check) {
                        if (array_key_exists($check->list_id, $answer_list) && $answer_list[$check->list_id] === true) {
                            $checkedCount++;
                        }
                    }
                    if ($checkedCount == $checklistCount) {
                        $score += $question->weight ?? 0;
                    }
                }
            }

            $examGrade = new ExamGrade();
            $examGrade->exam_schedule_id = $participantSchedule->exam_schedule_id;
            $examGrade->participant_id = $participantSchedule->participant_id;
            $examGrade->score = $score ?? 0;
            $examGrade->saveWithUUid();
        });
    }

    public function gradeStudiKasusByParticipantSchedule(ParticipantSchedule $participantSchedule)
    {
        DB::transaction(function () use ($participantSchedule) {
            $isExist = ExamGrade::where("exam_schedule_id", $participantSchedule->exam_schedule_id)
                ->where("participant_id", $participantSchedule->participant_id)
                ->exists();
            if ($isExist) {
                return;
            }

            $examQuestionList = $participantSchedule->examQuestionList($participantSchedule->participant_id);

            $score = 0;
            foreach ($examQuestionList as $examQuestion) {
                if ($examQuestion->id == 'studi_kasus_' . $participantSchedule->participant_id) {
                    continue;
                }
                if ($examQuestion->questionGroup?->association_id != 'examiner_studi_kasus') {
                    continue;
                }

                $question = $examQuestion->question;
                $answer = $examQuestion->answer;

                if ($answer) {
                    $score += min(($answer->score ?? 0), $question->weight);
                }
            }

            $examGrade = new ExamGrade();
            $examGrade->exam_schedule_id = $participantSchedule->exam_schedule_id;
            $examGrade->participant_id = $participantSchedule->participant_id;
            $examGrade->score = $score ?? 0;
            $examGrade->saveWithUUid();
        });
    }

    public function gradePraktikByParticipantSchedule(ParticipantSchedule $participantSchedule)
    {
        DB::transaction(function () use ($participantSchedule) {
            $isExist = ExamGrade::where("exam_schedule_id", $participantSchedule->exam_schedule_id)
                ->where("participant_id", $participantSchedule->participant_id)
                ->exists();
            if ($isExist) {
                return;
            }

            $examQuestionList = $participantSchedule->examQuestionList($participantSchedule->participant_id);

            $score = 0;
            foreach ($examQuestionList as $examQuestion) {
                if ($examQuestion->id == "base_praktik_question") {
                    continue;
                }
                $question = $examQuestion->question;
                $answer = $examQuestion->answer;

                if ($answer) {
                    $score += min(($answer->score ?? 0), $question->weight);
                }
            }

            $examGrade = new ExamGrade();
            $examGrade->exam_schedule_id = $participantSchedule->exam_schedule_id;
            $examGrade->participant_id = $participantSchedule->participant_id;
            $examGrade->score = $score ?? 0;
            $examGrade->saveWithUUid();
        });
    }
}
