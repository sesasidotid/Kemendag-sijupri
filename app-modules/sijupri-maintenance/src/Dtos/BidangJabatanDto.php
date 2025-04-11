<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class BidangJabatanDto extends BaseDto
{
    public $code;
    public $name;
    public $jabatan_code;

    public function validateSave()
    {
        return $this->validate([
            "name" => "required|string",
            "jabatan_code" => "required",
        ]);
        
    }

    public function validateUpdate()
    {
        return $this->validate([
            "code" => "required|string",
            "name" => "required|string",
        ]);
    }
}
