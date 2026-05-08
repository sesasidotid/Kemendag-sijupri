<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Carbon\Carbon;
use Eyegil\Base\Commons\EncriptionKey;
use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SijupriUkom\Services\ExamGradeService;
use Illuminate\Http\Request;

#[Controller("/api/v1/exam_grade")]
class ExamGradeController
{
    public function __construct(
        private ExamGradeService $examGradeService,
    ) {
    }

    #[Get("/download")]
    public function downloadTemplate()
    {
        return $this->examGradeService->downloadTemplate();
    }


    #[Get("/{exam_schedule_id}/{participant_id}")]
    public function findGradeByExamScheduleIdAndParticipantId(Request $request)
    {
        $userContext = user_context();
        $isJf = false;
        if (in_array($userContext->application_code, ["sijupri-internal", "sijupri-external"])) {
            $isJf = true;
        }
        return $this->examGradeService->findGradeByExamScheduleIdAndParticipantId(
            $request->exam_schedule_id,
            $request->participant_id,
            $isJf
        );
    }


    #[Get("/{exam_schedule_id}")]
    public function findGradeByExamScheduleIdAndParticipantIdWithKey(Request $request)
    {
        if (!$request->query->has('key'))
            throw new BusinessException("Parameter Key not found", "UKM-00004");
        $encriptionKey = new EncriptionKey($request->query("key"));

        $data = $encriptionKey->validate();
        if (!$data)
            throw new BusinessException("key not valid", "PASS-00001");
        $participant_ukom_id = $data->participant_ukom_id;

        return $this->examGradeService->findGradeByExamScheduleIdAndParticipantId(
            $request->exam_schedule_id,
            $participant_ukom_id,
            true
        );
    }

    #[Post("/upload")]
    public function uploadBulk(Request $request)
    {
        $request->validate(["file_grade" => "required"]);
        // UkomGradeJob::dispatch($request->file_grade);
    }

    #[Post("/trigger")]
    public function triggerGrading(Request $request)
    {
        $this->examGradeService->gradeAllExams();
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        $this->examGradeService->delete($id);
    }
}
