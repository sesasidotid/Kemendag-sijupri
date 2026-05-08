<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\SijupriUkom\Dtos\QuestionAnswerStateDto;
use Eyegil\SijupriUkom\Services\ExamQuestionService;
use Eyegil\SijupriUkom\Services\ExamService;
use Illuminate\Http\Request;

#[Controller("/api/v1/exam")]
class ExamController
{
    public function __construct(
        private ExamService $examService,
        private ExamQuestionService $examQuestionService,
    ) {
    }

    #[Post("/start")]
    public function start(Request $request)
    {
        $request->validate([
            "exam_schedule_id" => "required|string",
        ]);
        return $this->examService->start($request->exam_schedule_id, $request->secret_key);
    }

    #[Post("/examiner/start")]
    public function examinerStart(Request $request)
    {
        $request->validate([
            "exam_schedule_id" => "required|string",
            "participant_id" => "required|string",
        ]);
        return $this->examService->examinerStart($request->exam_schedule_id, $request->participant_id, $request->secret_key);
    }

    #[Post("/finish")]
    public function finish(Request $request)
    {
        $request->validate([
            "exam_schedule_id" => "required|string",
        ]);
        return $this->examService->finish($request->exam_schedule_id);
    }

    #[Get("/page/{exam_schedule_id}")]
    public function getExamPage(Request $request)
    {
        $query = $request->query();
        return $this->examService->getExamPage(
            $request->exam_schedule_id,
            $query['page'],
            $query['limit']
        );
    }

    #[Get("/page/examiner/{exam_schedule_id}/{participant_id}")]
    public function getExamPageExaminer($exam_schedule_id, $participant_id, Request $request)
    {
        $query = $request->query();
        return $this->examService->getExamPageExaminer(
            $exam_schedule_id,
            $participant_id,
            $query['page'],
            $query['limit']
        );
    }

    #[Post("/answer/{exam_schedule_id}")]
    public function answer(Request $request, $exam_schedule_id)
    {
        $answerDto = AnswerDto::fromRequest($request);
        return $this->examService->answer($answerDto, $exam_schedule_id);
    }

    #[Post("/answer/examiner/{exam_schedule_id}")]
    public function answerExaminer(Request $request, $exam_schedule_id)
    {
        $answer_dto_list = $request->input("answer_dto_list");
        return $this->examService->answerExaminer($answer_dto_list, $exam_schedule_id);
    }

    #[Post("/violation/{exam_schedule_id}")]
    public function violation(Request $request, $exam_schedule_id)
    {
        $request->validate([
            "remark" => "required|string",
        ]);
        $this->examService->countViolation($exam_schedule_id, $request->remark);
    }

    #[Post("/mouse_away/{exam_schedule_id}")]
    public function countMouseAway(Request $request, $exam_schedule_id)
    {
        $request->validate([
            "num_of_seconds" => "required|integer",
            "remark" => "required|string",
        ]);
        $this->examService->countMouseAway($exam_schedule_id, $request->num_of_seconds, $request->remark);
    }

    #[Get("/state/{exam_type_code}/{room_ukom_id}")]
    public function findState(Request $request)
    {
        $userContext = user_context();

        $examQuestionList = $this->examQuestionService->findQuestionByExamTypeCodeAndRoomUkomIdAndParticipantId(
            $request->exam_type_code,
            $request->room_ukom_id,
            $userContext->getDetails("participant_id")
        );

        $result = [];
        foreach ($examQuestionList as $examQuestion) {
            if ($examQuestion->answer) {
                foreach ($examQuestion->answer as $answer) {
                    $questionAnswerStateDto = new QuestionAnswerStateDto();
                    $questionAnswerStateDto->question_id = $examQuestion->question_id;
                    $questionAnswerStateDto->is_answered = true;
                    $questionAnswerStateDto->is_uncertain = $answer->is_uncertain;

                    $result[] = $questionAnswerStateDto;
                }
            }
        }

        return $result;
    }
}
