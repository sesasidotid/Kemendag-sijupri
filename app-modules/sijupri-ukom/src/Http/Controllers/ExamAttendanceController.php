<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriUkom\Services\ExamAttendanceService;
use Eyegil\SijupriUkom\Services\ExamScheduleService;
use Illuminate\Http\Request;

#[Controller("/api/v1/exam_attendance")]
class ExamAttendanceController
{
    public function __construct(
        private ExamAttendanceService $examAttendanceService,
        private ExamScheduleService $examScheduleService,
    ) {
    }

    #[Get("/{exam_schedule_id}/{participant_ukom_id}")]
    public function findAll(Request $request)
    {
        $examAttendance = $this->examAttendanceService->findByExamScheduleIdAndParticipantId(
            $request->exam_schedule_id,
            $request->participant_ukom_id,
        );
        $examSchedule = $this->examScheduleService->findById($request->exam_schedule_id);

        $examAttendanceData = $examAttendance->toArray();
        $examAttendanceData["duration"] = $examSchedule->duration;

        return $examAttendanceData;
    }

    #[Delete("/exam_schedule/{exam_schedule_id}")]
    public function deleteByExamScheduleId($exam_schedule_id)
    {
        $this->examAttendanceService->deleteByExamScheduleId($exam_schedule_id);
    }
}
