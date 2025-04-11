<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Carbon\Carbon;
use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Jobs\UkomGradeJob;
use Eyegil\SijupriUkom\Services\ExamGradeService;
use Illuminate\Http\Request;

#[Controller("/api/v1/exam_grade")]
class ExamGradeController
{
    public function __construct(
        private ExamGradeService $examGradeService,
    ) {}


    #[Get("/{exam_type_code}/{participant_id}")]
    public function findByExamTypeCodeAndParticipantId(Request $request)
    {
        return $this->examGradeService->findByExamTypeCodeAndParticipantId(
            $request->exam_type_code,
            $request->participant_id
        );
    }

    #[Get("/download")]
    public function downloadTemplate()
    {
        return $this->examGradeService->downloadTemplate();
    }

    #[Post("/upload")]
    public function uploadBulk(Request $request)
    {
        $request->validate(["file_grade" => "required"]);
        UkomGradeJob::dispatch($request->file_grade);
    }
}
