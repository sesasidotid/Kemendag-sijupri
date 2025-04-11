<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class ProvinsiDto extends BaseDto
{
    public $id;
    public $name;
    public $latitude;
    public $longitude;
    public $wilayah_code;

    public function validateSave()
    {
        return $this->validate([
            "name" => "required|string",
            "latitude" => "required",
            "longitude" => "required",
            "wilayah_code" => "required|string"
        ]);
        
    }

    public function validateUpdate()
    {
        return $this->validate([
            "id" => "required|string",
            "name" => "required|string",
            "latitude" => "required",
            "longitude" => "required",
            "wilayah_code" => "required|string"
        ]);
        
    }
}
