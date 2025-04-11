<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\SijupriUkom\Dtos\ExamAttendanceDto;
use Eyegil\SijupriUkom\Models\ExamAttendance;
use Illuminate\Support\Facades\DB;

class ExamAttendanceService
{

    public function findByExamTypeCodeAndRoomUkomIdAndParticipantId($exam_type_code, $room_ukom_id, $participant_ukom_id)
    {
        return ExamAttendance::where("exam_type_code", $exam_type_code)
            ->where("room_ukom_id", $room_ukom_id)
            ->where("participant_ukom_id", $participant_ukom_id)
            ->first();
    }

    public function save(ExamAttendanceDto $examAttendanceDto)
    {
        return DB::transaction(function () use ($examAttendanceDto) {
            $examAttendance = new ExamAttendance();
            $examAttendance->fromArray($examAttendanceDto->toArray());
            $examAttendance->saveWithUUid();

            return $examAttendance;
        });
    }

    public function update(ExamAttendanceDto $examAttendanceDto)
    {
        return DB::transaction(function () use ($examAttendanceDto) {
            $examAttendance = $this->findByExamTypeCodeAndRoomUkomIdAndParticipantId(
                $examAttendanceDto->exam_type_code,
                $examAttendanceDto->room_ukom_id,
                $examAttendanceDto->participant_ukom_id
            );

            if (!$examAttendance) {
                new RecordNotFoundException("attendance not found");
            }

            $examAttendance->fromArray($examAttendanceDto->toArray());
            $examAttendance->saveWithUUid();

            return $examAttendance;
        });
    }
}
