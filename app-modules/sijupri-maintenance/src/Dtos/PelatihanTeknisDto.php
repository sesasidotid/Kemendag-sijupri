<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class PelatihanTeknisDto extends BaseDto
{
    public $id;
    public $code;
    public $name;
    public $type;
    public $jabatan_code;
    public $jabatan_name;

    public function validateSave()
    {
        return $this->validate([
            "code" => "required",
            "name" => "required",
            "jabatan_code" => "required",
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            "id" => "required",
            "code" => "required",
            "name" => "required"
        ]);
    }
}
