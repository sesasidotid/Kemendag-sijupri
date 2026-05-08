<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class UpdateAssignerExaminer extends BaseDto
{
    public $examiner_schedule_id_list;

    public $participant_schedule_id;

    public function validateUpdate()
    {
        return $this->validate([
            "examiner_schedule_id_list" => "required",
            "participant_schedule_id" => "required",
        ]);
    }
}
