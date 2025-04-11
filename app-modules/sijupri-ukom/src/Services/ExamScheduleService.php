<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\SijupriUkom\Dtos\ExamScheduleDto;
use Eyegil\SijupriUkom\Dtos\RoomUkomDto;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Illuminate\Support\Facades\DB;

class ExamScheduleService
{
    public function findAllByRoomUkomId($room_ukom_id)
    {
        return ExamSchedule::where('room_ukom_id', $room_ukom_id)->get();
    }

    public function findByExamTypeCodeAndRoomUkomId($exam_type_code, $room_ukom_id)
    {
        return ExamSchedule::where('exam_type_code', $exam_type_code)
            ->where('room_ukom_id', $room_ukom_id)
            ->first();
    }

    public function findById($id)
    {
        return ExamSchedule::findOrThrowNotFound($id);
    }

    public function save(RoomUkomDto $roomUkomDto)
    {
        DB::transaction(function () use ($roomUkomDto) {
            $userContext = user_context();
            $this->deleteAllByRoomUkomId($roomUkomDto->id);

            foreach ($roomUkomDto->exam_schedule_dto_list as $key => $exam_schedule_dto) {
                $examScheduleDto = (new ExamScheduleDto())->fromArray((array) $exam_schedule_dto)->validateSave();

                $examSchedule = new ExamSchedule();
                $examSchedule->fromArray($examScheduleDto->toArray());
                $examSchedule->created_by = $userContext->id;
                $examSchedule->room_ukom_id = $roomUkomDto->id;
                $examSchedule->start_time = Carbon::parse($examScheduleDto->start_time);
                $examSchedule->end_time = Carbon::parse($examScheduleDto->end_time);
                $examSchedule->saveWithUuid();
            }
        });
    }

    public function deleteAllByRoomUkomId($room_ukom_id)
    {
        DB::transaction(function () use ($room_ukom_id) {
            ExamSchedule::where('room_ukom_id', $room_ukom_id)->delete();
        });
    }
}
