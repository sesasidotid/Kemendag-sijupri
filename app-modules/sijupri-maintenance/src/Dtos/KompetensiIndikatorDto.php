<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class KompetensiIndikatorDto extends BaseDto
{
    public $id;
    public $code;
    public $name;
    public $kompetensi_id;
    public $kompetensi_name;

    public $question_dto_list;

    public function validateSave()
    {
        return $this->validate([
            "name" => "required",
            "kompetensi_id" => "required",
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            "id" => "required",
            "name" => "required"
        ]);
    }
}
