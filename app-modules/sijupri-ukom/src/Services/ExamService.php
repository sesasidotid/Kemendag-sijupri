<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\EyegilLms\Dtos\ChecklistDto;
use Eyegil\EyegilLms\Dtos\MultipleChoiceDto;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\EyegilLms\Enums\QuestionType;
use Eyegil\EyegilLms\Models\Checklist;
use Eyegil\EyegilLms\Models\MultipleChoice;
use Eyegil\EyegilLms\Models\Question;
use Eyegil\EyegilLms\Services\AnswerService;
use Eyegil\EyegilLms\Services\QuestionService;
use Eyegil\SijupriUkom\Dtos\ExamAttendanceDto;
use Eyegil\SijupriUkom\Enums\ExamStatus;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Jobs\UkomGradeJob;
use Eyegil\SijupriUkom\Models\ExamConfiguration;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\SijupriUkom\Models\ParticipantSchedule;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;

class ExamService
{

    public function __construct(
        private QuestionService $questionService,
        private StorageService $storageService,
        private AnswerService $answerService,
        private ExamAttendanceService $examAttendanceService,
        private ExamScheduleService $examScheduleService,
    ) {
    }

    public function getExamPage($exam_schedule_id, $page = 1, $limit = 10)
    {
        $userContext = user_context();
        $examSchedule = $this->examScheduleService->findById($exam_schedule_id);

        try {
            $this->validateAttendance($exam_schedule_id, $userContext->getDetails("participant_id"));
        } catch (BusinessException $th) {
            if (!in_array($th->getCode(), ["STRT-00003", "RCD-00001"]) || $examSchedule->exam_type_code != ExamTypes::PRAKTIK->value) {
                throw $th;
            }
        }

        if ($examSchedule->exam_type_code == ExamTypes::MAKALAH->name) {
            $search = ExamQuestion::with(["answer", "question", "question.choices"])
                ->where("question_id", "base_makalah_question")
                ->where("exam_schedule_id", $exam_schedule_id)
                ->where("participant_ukom_id", $userContext->getDetails("participant_id"))
                ->paginate($limit, ['*'], 'page', $page);
        } else if ($examSchedule->exam_type_code == ExamTypes::SEMINAR->name) {
            $search = ExamQuestion::with(["answer", "question", "question.choices"])
                ->where("question_id", "base_makalah_question")
                ->where("exam_schedule_id", $exam_schedule_id)
                ->where("participant_ukom_id", $userContext->getDetails("participant_id"))
                ->paginate($limit, ['*'], 'page', $page);
        } else if ($examSchedule->exam_type_code == ExamTypes::PRAKTIK->name) {
            $search = ExamQuestion::with(["answer", "question", "question.choices"])
                ->where("question_id", "base_praktik_question")
                ->where("exam_schedule_id", $exam_schedule_id)
                ->where("participant_ukom_id", $userContext->getDetails("participant_id"))
                ->paginate($limit, ['*'], 'page', $page);
        } else if ($examSchedule->exam_type_code == ExamTypes::STUDI_KASUS->name) {
            $search = ExamQuestion::with(["answer", "question", "question.choices"])
                ->where("question_id", 'studi_kasus_' . $userContext->getDetails("participant_id"))
                ->where("exam_schedule_id", $exam_schedule_id)
                ->where("participant_ukom_id", $userContext->getDetails("participant_id"))
                ->paginate($limit, ['*'], 'page', $page);
        } else {
            $search = ExamQuestion::with(["answer", "question", "question.choices"])
                ->where("exam_schedule_id", $exam_schedule_id)
                ->where("participant_ukom_id", $userContext->getDetails("participant_id"))
                ->paginate($limit, ['*'], 'page', $page);
        }

        return $search->setCollection($search->getCollection()->map(function (ExamQuestion $examQuestion) use ($userContext) {
            $question = $examQuestion->question;

            $questionDto = new QuestionDto();
            $questionDto->fromModel($question);
            if ($question->attachment != null) {
                $questionDto->attachment_url = $this->storageService->getUrl("system", "lms", $question->attachment);
            }

            if ($question->choices) {
                $questionDto->multiple_choice_dto_list = $question->choices->map(function (MultipleChoice $multipleChoice) {
                    $multipleChoiceDto = (new MultipleChoiceDto())->fromModel($multipleChoice);
                    $multipleChoiceDto->correct = null;
                    return $multipleChoiceDto;
                });
            }

            if ($examQuestion->answer) {
                $questionDto->answer_dto = new AnswerDto();
                $questionDto->answer_dto->fromModel($examQuestion->answer);
                if ($questionDto->answer_dto->answer_upload) {
                    $questionDto->answer_dto->answer_upload_url = $this->storageService->getUrl("system", "lms", $questionDto->answer_dto->answer_upload);
                }
            }

            return $questionDto;
        }));
    }

    public function start($exam_schedule_id, $secret_key = null)
    {
        DB::transaction(function () use ($exam_schedule_id, $secret_key) {
            $examSchedule = $this->examScheduleService->findById($exam_schedule_id);

            if ($examSchedule->secret_key && $examSchedule->secret_key != $secret_key) {
                throw new BusinessException("Invalid Secret", code: "");
            }

            if (Carbon::now()->lessThan(Carbon::parse($examSchedule->start_time))) {
                if ($examSchedule->exam_type_code != ExamTypes::PRAKTIK->value) {
                    throw new BusinessException("Exam's not yet started", "STRT-00002");
                }
            }

            if ($examSchedule->exam_type_code != ExamTypes::PRAKTIK->value) {
                if (Carbon::now()->greaterThan(Carbon::parse($examSchedule->end_time))) {
                    throw new BusinessException("Exam's already ended", "STRT-00003");
                }
            }

            // $examSchedule this variable is exist. can get duration from it
            $userContext = user_context();
            $participantSchedule = ParticipantSchedule::where("exam_schedule_id", $exam_schedule_id)
                ->where("participant_id", $userContext->getDetails("participant_id"))
                ->firstOrThrowNotFound();

            if ($participantSchedule->personal_schedule) {
                $personalStart = Carbon::parse($participantSchedule->personal_schedule);
                $personalEnd = $personalStart->copy()->addHours((float) $examSchedule->duration);
                $now = Carbon::now();
                if (!($now->gte($personalStart) && $now->lt($personalEnd))) {
                    if ($examSchedule->exam_type_code != ExamTypes::PRAKTIK->value) {
                        throw new BusinessException("Exam's not yet started", "STRT-00002");
                    }
                }
            }

            if (
                !$this->examAttendanceService->findByExamScheduleIdAndParticipantId(
                    $exam_schedule_id,
                    $userContext->getDetails("participant_id")
                )
            ) {
                $examAttendanceDto = new ExamAttendanceDto();
                $examAttendanceDto->participant_ukom_id = $userContext->getDetails("participant_id");
                $examAttendanceDto->exam_schedule_id = $examSchedule->id;
                $examAttendanceDto->start_at = Carbon::now();

                $this->examAttendanceService->save($examAttendanceDto);

                $this->generateExamQuestion($examSchedule, $userContext->getDetails("participant_id"));
            }
        });
    }

    public function examinerStart($exam_schedule_id, $participant_id, $secret_key = null)
    {
        DB::transaction(function () use ($exam_schedule_id, $participant_id, $secret_key) {

            $examSchedule = $this->examScheduleService->findById($exam_schedule_id);

            if (Carbon::now()->lessThan(Carbon::parse($examSchedule->start_time))) {
                throw new BusinessException("Exam's not yet started", "");
            }

            // $examSchedule this variable is exist. can get duration from it
            $participantSchedule = ParticipantSchedule::where("exam_schedule_id", $examSchedule->id)
                ->where("participant_id", $participant_id)
                ->firstOrThrowNotFound();

            $now = Carbon::now();
            if ($participantSchedule->personal_schedule) {
                $personalStart = Carbon::parse($participantSchedule->personal_schedule);
                if (!$now->gte($personalStart)) {
                    throw new BusinessException("Exam's not yet started", "");
                }
            }

            if (
                !$this->examAttendanceService->findByExamScheduleIdAndParticipantId(
                    $examSchedule->id,
                    $participant_id
                )
            ) {
                $examAttendanceDto = new ExamAttendanceDto();
                $examAttendanceDto->participant_ukom_id = $participant_id;
                $examAttendanceDto->exam_schedule_id = $examSchedule->id;
                $examAttendanceDto->start_at = Carbon::now();

                $this->examAttendanceService->save($examAttendanceDto);

                $this->generateExamQuestion($examSchedule, $participant_id);
            }
        });
    }

    public function getExamPageExaminer($exam_schedule_id, $participant_id, $page = 1, $limit = 10)
    {
        $this->generateExamQuestion($this->examScheduleService->findById($exam_schedule_id), $participant_id->getDetails("participant_id"));

        $search = ExamQuestion::with(["answer", "question", "question.choices", "question.checkList"])
            ->where("exam_schedule_id", $exam_schedule_id)
            ->where("participant_ukom_id", $participant_id)
            ->orderBy('idx', 'asc')
            ->paginate($limit, ['*'], 'page', $page);

        return $search->setCollection($search->getCollection()->map(function (ExamQuestion $examQuestion) {
            $question = $examQuestion->question;
            $questionGroup = $question->questionGroup;
            $kompetensiIndikator = null;


            $questionDto = new QuestionDto();
            $questionDto->fromModel($question);
            if ($question->attachment != null) {
                $questionDto->attachment_url = $this->storageService->getUrl("system", "lms", $question->attachment);
            }

            if ($question->choices) {
                $questionDto->multiple_choice_dto_list = $question->choices->map(function (MultipleChoice $multipleChoice) {
                    $multipleChoiceDto = (new MultipleChoiceDto())->fromModel($multipleChoice);
                    $multipleChoiceDto->correct = null;
                    return $multipleChoiceDto;
                });
            }

            if ($question->checkList) {
                $questionDto->checklist_dto_list = $question->checkList->map(function (Checklist $checkList) {
                    $checkListDto = (new ChecklistDto())->fromModel($checkList);
                    return $checkListDto;
                });
            }

            if ($examQuestion->answer) {
                $questionDto->answer_dto = new AnswerDto();
                $questionDto->answer_dto->fromModel($examQuestion->answer);
                if ($questionDto->answer_dto->answer_upload) {
                    $questionDto->answer_dto->answer_upload_url = $this->storageService->getUrl("system", "lms", $questionDto->answer_dto->answer_upload);
                }
            }

            if ($questionGroup) {
                if ($questionGroup->association != "komponen") {
                    $kompetensiIndikator = $questionGroup->associationIndikator;

                    if ($kompetensiIndikator) {
                        $questionDto->kompetensi_indikator_id = $kompetensiIndikator->id;
                        $questionDto->kompetensi_indikator_name = $kompetensiIndikator->name;
                    }
                } else {
                    $questionDto->kompetensi_indikator_id = $questionGroup->association_id;
                    $questionDto->kompetensi_indikator_name = $questionGroup->association;
                }
            }

            return $questionDto;
        }));
    }

    public function countViolation($exam_schedule_id, $remark = null)
    {
        $isViolated = DB::transaction(function () use ($exam_schedule_id, $remark) {
            $userContext = user_context();

            $examAttendance = $this->examAttendanceService->addViloationCount(
                $exam_schedule_id,
                $userContext->getDetails("participant_id"),
                $remark
            );

            if ($examAttendance->status == ExamStatus::DISQUALIFIED->name) {
                $this->finish($exam_schedule_id, false);
                return true;
            }
        });

        if ($isViolated) {
            throw new BusinessException("Exam finished due to violation limit reached", "VIOLATION_LIMIT_REACHED");
        }
    }

    public function countMouseAway($exam_schedule_id, $num_of_seconds, $remark = null)
    {
        $isViolated = DB::transaction(function () use ($exam_schedule_id, $num_of_seconds, $remark) {
            $userContext = user_context();

            $examAttendance = $this->examAttendanceService->addMouseAway(
                $exam_schedule_id,
                $userContext->getDetails("participant_id"),
                $num_of_seconds,
                $remark
            );

            if ($examAttendance->status == ExamStatus::DISQUALIFIED->name) {
                $this->finish($exam_schedule_id, false);
                return true;
            }
        });

        if ($isViolated) {
            throw new BusinessException("Exam finished due to violation limit reached", "VIOLATION_LIMIT_REACHED");
        }
    }

    public function finish($exam_schedule_id, $isFinish = true)
    {
        DB::transaction(function () use ($exam_schedule_id, $isFinish) {
            $userContext = user_context();
            if ($isFinish) {
                $this->validateAttendance($exam_schedule_id, $userContext->getDetails("participant_id"), true);
            }

            $examAttendanceDto = new ExamAttendanceDto();
            $examAttendanceDto->participant_ukom_id = $userContext->getDetails("participant_id");
            $examAttendanceDto->exam_schedule_id = $exam_schedule_id;
            $examAttendanceDto->finish_at = Carbon::now();

            $examAttendance = $this->examAttendanceService->update($examAttendanceDto);

            if ($isFinish) {
                $examAttendance = $this->examAttendanceService->setFinish($examAttendance->id);
            }
            $examShcdule = $examAttendance->examSchedule;

            if (ExamTypes::CAT->value == $examShcdule->exam_type_code) {
                UkomGradeJob::dispatch([ExamTypes::CAT->value], $userContext->getDetails("participant_id"));
            }
        });
    }

    public function answer(AnswerDto $answerDto, $exam_schedule_id)
    {
        DB::transaction(function () use ($answerDto, $exam_schedule_id) {
            $userContext = user_context();
            $this->validateAttendance($exam_schedule_id, $userContext->getDetails("participant_id"));

            $examQuestion = ExamQuestion::where("exam_schedule_id", $exam_schedule_id)
                ->where("participant_ukom_id", $userContext->getDetails("participant_id"))
                ->where("question_id", $answerDto->question_id)
                ->firstOrThrowNotFound();
            $question = $examQuestion->question;

            if (QuestionType::MULTI_CHOICE->name == $question->type) {
                $answerDto->validateSaveMultipleChoice();
            }
            // else if (QuestionType::UPLOADS->name == $question->type) {
            //     $answerDto->validateSaveUpload();
            // } else if (QuestionType::ESSAY->name == $question->type) {
            //     $answerDto->validateSaveEssay();
            // }

            if ($examQuestion->answer) {
                $answerDto->id = $examQuestion->answer->id;
                $answer = $this->answerService->save($answerDto);
            } else {
                $answer = $this->answerService->save($answerDto);
                $examQuestion->answer_id = $answer->id;
                $examQuestion->save();

                if ($examQuestion->examSchedule->exam_type_code == ExamTypes::MAKALAH->value) {
                    $examQuestionSeminar = ExamQuestion::where("exam_schedule_id", $examQuestion->examSchedule->examScheduleChild->id)
                        ->where("participant_ukom_id", $userContext->getDetails("participant_id"))
                        ->where("question_id", $answerDto->question_id)
                        ->firstOrThrowNotFound();

                    $examQuestionSeminar->answer_id = $answer->id;
                    $examQuestionSeminar->save();
                }
            }
        });
    }

    public function answerExaminer($answer_dto_list, $exam_schedule_id)
    {
        DB::transaction(function () use ($answer_dto_list, $exam_schedule_id) {
            $participant_id = null;
            foreach ($answer_dto_list as $answer_dto) {
                $answerDto = new AnswerDto();
                $answerDto->fromArray((array) $answer_dto)->validateSave();

                $examQuestion = ExamQuestion::where("exam_schedule_id", $exam_schedule_id)
                    ->where("participant_ukom_id", $answerDto->participant_id)
                    ->where("question_id", $answerDto->question_id)
                    ->firstOrThrowNotFound();

                if ($examQuestion->answer) {
                    $answerDto->id = $examQuestion->answer->id;
                    $answer = $this->answerService->save($answerDto);
                } else {
                    $answer = $this->answerService->save($answerDto);
                    $examQuestion->answer_id = $answer->id;
                    $examQuestion->save();
                }

                $participant_id = $answerDto->participant_id;
            }

            ParticipantSchedule::where("participant_id", $participant_id)
                ->where("exam_schedule_id", $exam_schedule_id)
                ->update([
                    "examined" => true
                ]);

            $examAttendanceDto = new ExamAttendanceDto();
            $examAttendanceDto->participant_ukom_id = $participant_id;
            $examAttendanceDto->exam_schedule_id = $exam_schedule_id;
            $examAttendanceDto->finish_at = Carbon::now();
            $examAttendance = $this->examAttendanceService->update($examAttendanceDto);

            $examSchedule = $examAttendance->examSchedule;
            $examSchedule->save();
        });
    }

    private function validateAttendance($exam_schedule_id, $participant_id, $ignoreStatus = false)
    {
        $examAttendance = $this->examAttendanceService->findByExamScheduleIdAndParticipantId(
            $exam_schedule_id,
            participant_ukom_id: $participant_id
        );

        if (!$examAttendance) {
            throw new RecordNotFoundException("attendance not found");
        } else if ($examAttendance->finish_at) {
            throw new BusinessException("Exam's already ended", "STRT-00003");
        } else if (!$ignoreStatus) {
            if ($examAttendance->status == ExamStatus::DISQUALIFIED->name) {
                throw new BusinessException("Exam finished due to violation limit reached", "VIOLATION_LIMIT_REACHED");
            }
        }
    }

    private function generateExamQuestion($examSchedule, $participant_id)
    {

        DB::transaction(function () use ($examSchedule, $participant_id) {

            $isExist = ExamQuestion::where("participant_ukom_id", $participant_id)
                ->where("exam_schedule_id", $examSchedule->id)
                ->exists();
            if ($isExist) {
                return;
            }

            $lockKey = crc32("exam_gen_{$participant_id}_{$examSchedule->id}");
            DB::statement("SELECT pg_advisory_xact_lock(?)", [$lockKey]);

            if ($examSchedule->exam_type_code == ExamTypes::SEMINAR->value) {
                $examSchedule = $examSchedule->examScheduleParent;
            }

            $examConfiguration = ExamConfiguration::with("examSuffleConfigurationList")
                ->where("exam_schedule_id", $examSchedule->id)
                ->first();

            if (!$examConfiguration || !$examConfiguration->examSuffleConfigurationList || $examConfiguration->examSuffleConfigurationList->isEmpty()) {
                if ($examSchedule->exam_type_code == ExamTypes::MAKALAH->value) {
                    $baseQuestion = $this->questionService->findById("base_makalah_question");

                    $examQuestion = new ExamQuestion();
                    $examQuestion->exam_schedule_id = $examSchedule->id;
                    $examQuestion->question_id = $baseQuestion->id;
                    $examQuestion->participant_ukom_id = $participant_id;
                    $examQuestion->idx = 1;
                    $examQuestion->saveWithUUid();

                    $questionList = $this->questionService->findByParentQuestionId($baseQuestion->id, ["a"]);

                    foreach ($questionList as $childQuestion) {
                        $examQuestion = new ExamQuestion();
                        $examQuestion->exam_schedule_id = $examSchedule->id;
                        $examQuestion->question_id = $childQuestion->id;
                        $examQuestion->participant_ukom_id = $participant_id;
                        $examQuestion->idx = 999;
                        $examQuestion->saveWithUUid();
                    }

                    $examScheduleSeminar = $examSchedule->examScheduleChild;

                    $examQuestion = new ExamQuestion();
                    $examQuestion->exam_schedule_id = $examScheduleSeminar->id;
                    $examQuestion->question_id = $baseQuestion->id;
                    $examQuestion->participant_ukom_id = $participant_id;
                    $examQuestion->idx = 1;
                    $examQuestion->saveWithUUid();

                    $questionList = $this->questionService->findByParentQuestionId($baseQuestion->id, ["b", "c"]);

                    foreach ($questionList as $childQuestion) {
                        $examQuestion = new ExamQuestion();
                        $examQuestion->exam_schedule_id = $examScheduleSeminar->id;
                        $examQuestion->question_id = $childQuestion->id;
                        $examQuestion->participant_ukom_id = $participant_id;
                        $examQuestion->idx = 999;
                        $examQuestion->saveWithUUid();
                    }
                } else if ($examSchedule->exam_type_code == ExamTypes::PRAKTIK->value) {
                    $question = $this->questionService->findById("base_praktik_question");

                    $examQuestion = new ExamQuestion();
                    $examQuestion->exam_schedule_id = $examSchedule->id;
                    $examQuestion->question_id = $question->id;
                    $examQuestion->participant_ukom_id = $participant_id;
                    $examQuestion->saveWithUUid();

                    $roomUkom = $examSchedule->roomUkom;
                    $questionList = $this->questionService->findByParentQuestionIdV2($question->id);
                    foreach ($questionList as $question) {
                        $examQuestion = new ExamQuestion();
                        $examQuestion->exam_schedule_id = $examSchedule->id;
                        $examQuestion->question_id = $question->id;
                        $examQuestion->participant_ukom_id = $participant_id;
                        $examQuestion->saveWithUUid();
                    }

                } else if ($examSchedule->exam_type_code == ExamTypes::STUDI_KASUS->value) {
                    $roomUkom = $examSchedule->roomUkom;
                    $questionList = $this->questionService->findByModuleIdAndJabatanCodeAndJenjangCodeAndBidangJabatanCode(ExamTypes::STUDI_KASUS->value, $roomUkom->jabatan_code, $roomUkom->jenjang_code, $roomUkom->bidang_jabatan_code);

                    $pdf = new Fpdi();
                    $files = [];
                    foreach ($questionList as $question) {
                        $files[] = storage_path('app/buckets/lms/' . $question->attachment);
                    }

                    foreach ($files as $file) {
                        $pageCount = $pdf->setSourceFile($file);

                        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                            $templateId = $pdf->importPage($pageNo);
                            $size = $pdf->getTemplateSize($templateId);

                            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                            $pdf->useTemplate($templateId);
                        }
                    }

                    $pdf->Output(storage_path('app/buckets/lms/soal_' . $participant_id . '.pdf'), 'F');

                    $questionId = 'studi_kasus_' . $participant_id;
                    $question = $this->questionService->findByIdV2($questionId);

                    if (!$question) {
                        $questionDto = new QuestionDto();
                        $questionDto->id = $questionId;
                        $questionDto->question = "Silahkan unduh soal ujian";
                        $questionDto->attachment = 'soal_' . $participant_id . '.pdf';
                        $questionDto->module_id = ExamTypes::STUDI_KASUS;
                        $questionDto->type = QuestionType::UPLOADS;

                        $question = $this->questionService->saveV2($questionDto);
                    }

                    $examQuestion = new ExamQuestion();
                    $examQuestion->exam_schedule_id = $examSchedule->id;
                    $examQuestion->question_id = $question->id;
                    $examQuestion->participant_ukom_id = $participant_id;
                    $examQuestion->saveWithUUid();

                    // examiner only below

                    $examinerQuestionList = $this->questionService->findByModuleIdAndAssociationAndAssociationId(ExamTypes::STUDI_KASUS->value, "examiner_studi_kasus", "examiner_studi_kasus");
                    foreach ($examinerQuestionList as $question) {
                        $examQuestion = new ExamQuestion();
                        $examQuestion->exam_schedule_id = $examSchedule->id;
                        $examQuestion->question_id = $question->id;
                        $examQuestion->participant_ukom_id = $participant_id;
                        $examQuestion->idx = 999;
                        $examQuestion->saveWithUUid();
                    }

                } else if ($examSchedule->exam_type_code == ExamTypes::CAT->value) {
                } else {
                    $roomUkom = $examSchedule->roomUkom;
                    $questionList = $this->questionService->findByModuleIdAndJabatanCodeAndJenjangCodeAndBidangJabatanCode($examSchedule->exam_type_code, $roomUkom->jabatan_code, $roomUkom->jenjang_code, $roomUkom->bidang_jabatan_code);
                    foreach ($questionList as $question) {
                        $examQuestion = new ExamQuestion();
                        $examQuestion->exam_schedule_id = $examSchedule->id;
                        $examQuestion->question_id = $question->id;
                        $examQuestion->participant_ukom_id = $participant_id;
                        $examQuestion->saveWithUUid();
                    }
                }
            } else {
                $examConfiguration->examSuffleConfigurationList->each(function ($examSuffleConfiguration) use ($examSchedule, $participant_id) {
                    $questionList = $this->questionService->findByModuleIdAndAssociationAndAssociationIdWithLimit(
                        $examSchedule->exam_type_code,
                        'mnt_kompetensi_indikator',
                        $examSuffleConfiguration->kompetensi_indikator_id,
                        $examSuffleConfiguration->num_of_question
                    );

                    foreach ($questionList as $question) {
                        $examQuestion = new ExamQuestion();
                        $examQuestion->exam_schedule_id = $examSchedule->id;
                        $examQuestion->question_id = $question->id;
                        $examQuestion->participant_ukom_id = $participant_id;
                        $examQuestion->saveWithUUid();
                    }
                });
            }
        });
    }
}
