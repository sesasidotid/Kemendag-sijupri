<?php

namespace Eyegil\SijupriUkom\Converters;

use Eyegil\SijupriUkom\Dtos\ExamScheduleDto;
use Eyegil\SijupriUkom\Dtos\RoomUkomDto;
use Eyegil\SijupriUkom\Models\RoomUkom;

class RoomUkomConverter
{
    public static function toDto(RoomUkom $roomUkom): RoomUkomDto
    {
        $roomUkomDto = new RoomUkomDto();
        $roomUkomDto->fromModel($roomUkom);

        $roomUkomDto->jabatan_name = $roomUkom->jabatan->name;
        $roomUkomDto->jenjang_name = $roomUkom->jenjang->name;
        if ($roomUkom->bidang_jabatan_code) {
            $roomUkomDto->bidang_jabatan_name = $roomUkom->bidangJabatan->name;
        }

        return $roomUkomDto;
    }

    public static function withSchedule(RoomUkom $roomUkom): RoomUkomDto
    {
        $roomUkomDto = static::toDto($roomUkom);

        $roomUkomDto->exam_schedule_dto_list = [];
        foreach ($roomUkom->examScheduleList as $key => $examSchedule) {
            $examScheduleDto = (new ExamScheduleDto())->fromModel($examSchedule);
            $roomUkomDto->exam_schedule_dto_list[] = $examScheduleDto;
        }

        return $roomUkomDto;
    }
}
