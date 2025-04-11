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

    public function save(RoomUkomQuestionDto $RoomUkomQuestionDto)
    {
        DB::transaction(function () use ($RoomUkomQuestionDto) {
            $userContext = user_context();

            $this->deleteByRommIdAndExamTypeCode($RoomUkomQuestionDto->id, $RoomUkomQuestionDto->exam_type_code);

            foreach ($RoomUkomQuestionDto->question_id_list as $key => $question_id) {
                $question = $this->questionService->findById($question_id);

                if ($question->module_id != $RoomUkomQuestionDto->exam_type_code) {
                    throw new BusinessException("module not match with exam type", "", [
                        "exam_type_code" => $RoomUkomQuestionDto->exam_type_code,
                        "module_id" => $question->module_id
                    ]);
                }

                $examQuestion = new ExamQuestion();
                $examQuestion->room_ukom_id = $RoomUkomQuestionDto->id;
                $examQuestion->question_id = $question->id;
                $examQuestion->exam_type_code = $question->module_id;
                $examQuestion->saveWithUuid();
            }
        });
    }

    public function deleteByRommIdAndExamTypeCode($room_ukom_id, $exam_type_code)
    {
        DB::transaction(function () use ($room_ukom_id, $exam_type_code) {
            ExamQuestion::where("room_ukom_id", $room_ukom_id)
                ->where("exam_type_code", $exam_type_code)
                ->delete();
        });
    }
}
