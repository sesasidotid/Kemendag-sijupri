<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class UpdateAssignerParticipant extends BaseDto
{
    public $participant_schedule_id;

    public $personal_schedule;

    public function validateUpdate()
    {
        return $this->validate([
            "participant_schedule_id" => "required",
            "examiner_schedule_id_list" => "required",
        ]);
    }
}
