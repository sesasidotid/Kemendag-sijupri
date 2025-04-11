<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExamScheduleDto extends BaseDto
{

    public $id;
    public $start_time;
    public $end_time;
    public $exam_type_code;
    public $room_ukom_id;

    public function validateSave()
    {
        return $this->validate([
            "start_time" => "required",
            "end_time" => "required",
            "exam_type_code" => "required|string"
        ]);
    }
}
