<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExamScheduleUpdateDto extends BaseDto
{

    public $id;
    public $start_time;
    public $end_time;
    public $duration;
    public $secret_key;

    public function validateUpdate()
    {
        return $this->validate([
            "id" => "required",
            "start_time" => "required",
            "end_time" => "required",
            "duration" => "required",
        ]);
    }
}
