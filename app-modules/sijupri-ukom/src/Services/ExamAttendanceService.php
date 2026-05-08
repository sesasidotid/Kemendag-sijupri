<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\SijupriMaintenance\Services\SystemConfigurationService;
use Eyegil\SijupriUkom\Dtos\ExamAttendanceDto;
use Eyegil\SijupriUkom\Enums\ExamStatus;
use Eyegil\SijupriUkom\Models\ExamAttendance;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\SijupriUkom\Models\ViolationLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamAttendanceService
{

    public function __construct(
        private SystemConfigurationService $sysConfService
    ) {
    }

    public function findById($id)
    {
        return ExamAttendance::findOrThrowNotFound($id);
    }

    public function findByExamScheduleIdAndParticipantId($exam_schedule_id, $participant_ukom_id)
    {
        return ExamAttendance::where("exam_schedule_id", $exam_schedule_id)
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
            $examAttendance = $this->findByExamScheduleIdAndParticipantId(
                $examAttendanceDto->exam_schedule_id,
                $examAttendanceDto->participant_ukom_id
            );

            if (!$examAttendance) {
                throw new RecordNotFoundException("attendance not found");
            }

            $examAttendance->fromArray($examAttendanceDto->toArray());
            $examAttendance->save();

            return $examAttendance;
        });
    }

    public function addViloationCount($exam_schedule_id, $participant_ukom_id, $remark = null)
    {
        return DB::transaction(function () use ($exam_schedule_id, $participant_ukom_id, $remark) {
            $examAttendance = $this->findByExamScheduleIdAndParticipantId(
                $exam_schedule_id,
                $participant_ukom_id
            );

            if (!$examAttendance) {
                throw new RecordNotFoundException("attendance not found");
            }

            $sysConfig = $this->sysConfService->findByCode("UKM_MAX_VIOLATION");
            $violationThreshold = (int) $sysConfig->value;


            $examAttendance->violation_count += 1;
            if ($examAttendance->violation_count >= $violationThreshold) {
                $examAttendance->status = ExamStatus::DISQUALIFIED->value;
            }
            $examAttendance->save();

            ViolationLog::create([
                'id' => Str::uuid(),
                'exam_attendance_id' => $examAttendance->id,
                'remark' => $remark,
            ]);

            return $examAttendance;
        });
    }

    public function setFinish($id)
    {
        return DB::transaction(function () use ($id) {
            $examAttendance = $this->findById($id);
            $examAttendance->status = ExamStatus::FINISHED->value;
            $examAttendance->save();

            return $examAttendance;
        });
    }

    public function addMouseAway($exam_schedule_id, $participant_ukom_id, $num_of_seconds, $remark = null)
    {
        return DB::transaction(function () use ($exam_schedule_id, $participant_ukom_id, $num_of_seconds, $remark) {
            $examAttendance = $this->findByExamScheduleIdAndParticipantId(
                $exam_schedule_id,
                $participant_ukom_id
            );

            if (!$examAttendance) {
                throw new RecordNotFoundException("attendance not found");
            }

            $sysConfig = $this->sysConfService->findByCode("UKM_MAUSE_AWAY_TIMEOUT");
            $violationThreshold = (int) $sysConfig->value;

            $examAttendance->mouse_away_count += $num_of_seconds;
            if ($examAttendance->mouse_away_count >= $violationThreshold) {
                $examAttendance->status = ExamStatus::DISQUALIFIED->name;
            }
            $examAttendance->save();

            ViolationLog::create([
                'id' => Str::uuid(),
                'exam_attendance_id' => $examAttendance->id,
                'remark' => $remark,
            ]);

            return $examAttendance;
        });
    }

    public function deleteByExamTypeCodeAndRoomUkomIdAndParticipantId($exam_type_code, $room_ukom_id, $participant_ukom_id)
    {
        DB::transaction(function () use ($exam_type_code, $room_ukom_id, $participant_ukom_id) {
            ExamAttendance::where("exam_type_code", $exam_type_code)
                ->where("room_ukom_id", $room_ukom_id)
                ->where("participant_ukom_id", $participant_ukom_id)
                ->delete();
        });
    }

    public function deleteByExamScheduleId($exam_schedule_id)
    {
        DB::transaction(function () use ($exam_schedule_id) {
            ExamAttendance::where("exam_schedule_id", $exam_schedule_id)->delete();
            ExamQuestion::where("exam_schedule_id", $exam_schedule_id)->delete();
        });
    }
}
