<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExamScheduleCatDto extends BaseDto
{
    public $id;
    public $start_time;
    public $end_time;
    public $duration;
    public $room_ukom_id;
    public $secret_key;

    public $participant_id_list;

    public function validateSave()
    {
        return $this->validate([
            "room_ukom_id" => "required",
            "start_time" => "required",
            "end_time" => "required",
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            "id" => "required",
            "start_time" => "required",
            "end_time" => "required",
        ]);
    }
}
