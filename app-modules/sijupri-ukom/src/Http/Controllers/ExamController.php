<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\EyegilLms\Dtos\AnswerDto;
use Eyegil\SijupriUkom\Services\ExamService;
use Illuminate\Http\Request;

#[Controller("/api/v1/exam")]
class ExamController
{
    public function __construct(
        private ExamService $examService,
    ) {}

    #[Post("/start")]
    public function start(Request $request)
    {
        $request->validate([
            "exam_type_code" => "required|string",
            "room_ukom_id" => "required|string",
        ]);
        return $this->examService->start($request->exam_type_code, $request->room_ukom_id);
    }

    #[Post("/finish")]
    public function finish(Request $request)
    {
        $request->validate([
            "exam_type_code" => "required|string",
            "room_ukom_id" => "required|string",
        ]);
        return $this->examService->finish($request->exam_type_code, $request->room_ukom_id);
    }

    #[Get("/page/{exam_type_code}/{room_ukom_id}")]
    public function getExamPage(Request $request)
    {
        $query = $request->query();
        return $this->examService->getExamPage(
            $request->exam_type_code,
            $request->room_ukom_id,
            $query['page'],
            $query['limit']
        );
    }

    #[Post("/answer")]
    public function save(Request $request)
    {
        $answerDto = AnswerDto::fromRequest($request)->validateSaveMultipleChoice();
        return $this->examService->answer($answerDto);
    }
}
