<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\EyegilLms\Dtos\MultipleChoiceDto;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Enums\QuestionType;
use Eyegil\EyegilLms\Models\MultipleChoice;
use Eyegil\EyegilLms\Services\AnswerService;
use Eyegil\SijupriMaintenance\Dtos\KompetensiDto;
use Eyegil\SijupriMaintenance\Services\KompetensiService;
use Eyegil\SijupriUkom\Dtos\ExamGradeDto;
use Eyegil\SijupriUkom\Dtos\ExamGradeUploadDto;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Enums\ExamTypesMansoskul;
use Eyegil\SijupriUkom\Models\ExamGrade;
use Eyegil\SijupriUkom\Models\ExamGradeMansoskul;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Eyegil\SijupriUkom\Models\RoomUkom;
use Eyegil\SijupriUkom\Models\UkomFormula;
use Eyegil\SijupriUkom\Models\UkomGrade;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExamGradeService
{

    public function __construct(
        private KompetensiService $kompetensiService,
        private StorageService $storageService,
        private StorageSystemService $storageSystemService,
        private AnswerService $answerService,
        private ExamQuestionService $examQuestionService,
        private ParticipantUkomService $participantUkomService,
    ) {}

    public function findByOnlyExamTypeCodeAndRoomUkomIdAndParticipantId($exam_type_code, $room_ukom_id, $participant_id)
    {
        return ExamGrade::where("exam_type_code", $exam_type_code)
            ->where("room_ukom_id", $room_ukom_id)
            ->where("participant_id", $participant_id)
            ->first();
    }

    public function findByExamTypeCodeAndParticipantId($exam_type_code, $participant_id)
    {
        $examGrade = ExamGrade::where("exam_type_code", $exam_type_code)
            ->where("participant_id", $participant_id)
            ->firstOrThrowNotFound();

        $examGradeDto = (new ExamGradeDto())->fromModel($examGrade);
        $tempKompetensi = [];

        $examQuestionList = $examGrade->examQuestionList()->whereHas("question.answer", function (Builder $query) use ($participant_id) {
            $query->where("participant_id", $participant_id);
        })->get();

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
                if (!isset($tempKompetensi[$questionGroup->association_id])) {
                    $kompetensi = $this->kompetensiService->findById($questionGroup->association_id);
                    $kompetensiDto = (new KompetensiDto())->fromModel($kompetensi);
                    $kompetensiDto->question_dto_list = [$questionDto];

                    $tempKompetensi[$questionGroup->association_id] = $kompetensiDto;
                } else {
                    $tempKompetensi[$questionGroup->association_id]->question_dto_list[] = $questionDto;
                }
            }
        }

        $examGradeDto->kompetensi_dto_list = array_values($tempKompetensi);
        return $examGradeDto;
    }

    public function downloadTemplate()
    {
        return $this->storageSystemService->downloadFile("template", "template_grade.xlsx");
    }

    public function gradeExam()
    {
        $examScheduleList = ExamSchedule::where("end_time", '<', Carbon::now()->subMinutes(5))
            ->whereHas("roomUkom", function (Builder $query) {
                $query->where("delete_flag", false)
                    ->where("inactive_flag", false);
            })
            ->get();

        foreach ($examScheduleList as $examSchedule) {
            $examQuestionList = $this->examQuestionService->findByExamTypeCodeAndRoomUkomId(
                $examSchedule->exam_type_code,
                $examSchedule->room_ukom_id
            );

            switch ($examSchedule->exam_type_code) {
                case ExamTypes::CAT->value:
                    $this->gradeExamCAT(
                        $examQuestionList,
                        $examSchedule->exam_type_code,
                        $examSchedule->room_ukom_id
                    );
                    break;
            }
        }
    }

    public function gradeExamCatByExamQuestionListAndRoomUkomIdAndParticipantId($examQuestionList, $room_ukom_id, $participant_id)
    {
        DB::transaction(function () use ($examQuestionList, $room_ukom_id, $participant_id) {
            $questionCount = count($examQuestionList);

            foreach ($examQuestionList as $examQuestion) {
                $correctCount = 0;

                if ($questionCount > 0) {
                    foreach ($examQuestionList as $examQuestion) {
                        $question = $examQuestion->question;
                        $choices = $question->choices;

                        $answer = $this->answerService->findByQuestionIdAndParticipantId($question->id, $participant_id);

                        if ($answer) {
                            foreach ($choices as $choice) {
                                if (strtolower($choice->choice_id) == strtolower($answer->answer_choice)) {
                                    if ($choice->correct)
                                        $correctCount++;
                                    break;
                                }
                            }
                        } else {
                            $answerDto = new AnswerDto();
                            $answerDto->answer_choice = null;
                            $answerDto->participant_id = $participant_id;
                            $answerDto->question_id = $question->id;
                            $answerDto->question_type = QuestionType::MULTI_CHOICE->value;

                            $answer = $this->answerService->save($answerDto);
                        }
                    }
                }

                $score = ($questionCount > 0) ? ($correctCount / $questionCount) * 100 : 0;

                $examGrade = new ExamGrade();
                $examGrade->exam_type_code = ExamTypes::CAT->value;
                $examGrade->room_ukom_id = $room_ukom_id;
                $examGrade->participant_id = $participant_id;
                $examGrade->score = $score;
                $examGrade->saveWithUUid();
            }
        });
    }

    private function gradeExamCAT($examQuestionList, $exam_type_code, $room_ukom_id)
    {
        try {
            DB::transaction(function () use ($examQuestionList, $exam_type_code, $room_ukom_id) {
                $questionCount = count($examQuestionList);

                $participantUkomList = collect();
                foreach ($examQuestionList as $examQuestion) {
                    $participantUkomList = $this->participantUkomService->findByRoomId($examQuestion->room_ukom_id);
                }

                foreach ($participantUkomList as $participantUkom) {
                    if ($this->findByOnlyExamTypeCodeAndRoomUkomIdAndParticipantId(
                        $exam_type_code,
                        $room_ukom_id,
                        $participantUkom->id
                    )) continue;
                    $this->gradeExamCatByExamQuestionListAndRoomUkomIdAndParticipantId(
                        $examQuestionList,
                        $room_ukom_id,
                        $participantUkom->id
                    );
                }
            });
        } catch (\Throwable $th) {
            Log::error("Failed to create exam grade on exam type: $exam_type_code and at room: $room_ukom_id");
            Log::error($th->getMessage(), ['stack' => $th->getTraceAsString()]);
        }
    }
}
