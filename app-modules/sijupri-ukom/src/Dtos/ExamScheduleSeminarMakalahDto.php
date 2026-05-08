<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExamScheduleSeminarMakalahDto extends BaseDto
{
    public $id;
    public $makalah_start_time;
    public $makalah_end_time;
    public $seminar_start_time;
    public $seminar_end_time;
    public $duration;
    public $room_ukom_id;

    public $personal_schedule;

    public $participant_id_list;

    public $examiner_id_list;

    public $examiner_amount;

    public function validateSave()
    {
        return $this->validate([
            "room_ukom_id" => "required",
            "makalah_start_time" => "required",
            "makalah_end_time" => "required",
            "seminar_start_time" => "required",
            "seminar_end_time" => "required",
            "duration" => "required",
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            "id" => "required",
            "makalah_start_time" => "required",
            "makalah_end_time" => "required",
            "seminar_start_time" => "required",
            "seminar_end_time" => "required",
        ]);
    }
}
