<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Pageable;
use Eyegil\EyegilLms\Services\QuestionService;
use Eyegil\SijupriUkom\Dtos\RoomUkomQuestionDto;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Illuminate\Support\Facades\DB;

class ExamQuestionService
{
    public function __construct(
        private QuestionService $questionService
    ) {}

    public function findByExamScheduleId($exam_schedule_id)
    {
        return ExamQuestion::with(["question", "question.choices"])->where("exam_schedule_id", $exam_schedule_id)->get();
    }

    public function findByExamTypeCodeAndRoomUkomId($exam_type_code, $room_ukom_id)
    {
        return ExamQuestion::with(["question", "question.choices"])->where("exam_type_code", $exam_type_code)
            ->where("room_ukom_id", $room_ukom_id)
            ->get();
    }

    public function findSearch(Pageable $pageable, $exam_type_code, $room_ukom_id)
    {
        $pageable->addEqual('exam_type_code', $exam_type_code);
        $pageable->addEqual('room_ukom_id', $room_ukom_id);
        return $pageable->with(["question"])->searchHas(ExamQuestion::class, ["questionGroup", "question"]);
    }

    public function findQuestionByExamTypeCodeAndRoomUkomIdAndParticipantId($exam_type_code, $room_ukom_id, $participant_id)
    {
        return ExamQuestion::where('room_ukom_id', $room_ukom_id)
            ->where('exam_type_code', $exam_type_code)
            ->whereHas('answer', function ($query) use ($participant_id) {
                $query->where('participant_id', $participant_id);
            })
            ->with(['answer' => function ($query) use ($participant_id) {
                $query->where('participant_id', $participant_id)
                    ->select('question_id', 'is_uncertain');
            }])
            ->get();
    }

    public function deleteByRoomIdAndExamTypeCode($room_ukom_id, $exam_type_code)
    {
        DB::transaction(function () use ($room_ukom_id, $exam_type_code) {
            ExamQuestion::where("room_ukom_id", $room_ukom_id)
                ->where("exam_type_code", $exam_type_code)
                ->delete();
        });
    }
}
