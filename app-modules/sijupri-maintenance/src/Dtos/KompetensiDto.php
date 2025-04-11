<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class KompetensiDto extends BaseDto
{
    public $id;
    public $code;
    public $name;
    public $description;
    public $type;
    public $jabatan_code;
    public $jabatan_name;
    public $jenjang_code;
    public $jenjang_name;
    public $bidang_jabatan_code;
    public $bidang_jabatan_name;

    public $question_dto_list;

    public function validateSave()
    {
        return $this->validate([
            "code" => "required",
            "name" => "required",
            "jabatan_code" => "required",
            "jenjang_code" => "required",
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
