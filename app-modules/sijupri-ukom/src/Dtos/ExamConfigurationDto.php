<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExamConfigurationDto extends BaseDto
{
    public $id;
    public $exam_schedule_id;
    public $exam_shuffle_configuration_dto_list;

    public function validateShuffle()
    {
        return $this->validate([
            "exam_schedule_id" => "required",
            "exam_shuffle_configuration_dto_list" => "required",
        ]);
    }
}
