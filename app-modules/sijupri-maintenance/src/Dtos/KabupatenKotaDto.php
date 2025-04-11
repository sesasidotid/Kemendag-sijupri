<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class KabupatenKotaDto extends BaseDto
{
    public $id;
    public $name;
    public $type;
    public $latitude;
    public $longitude;
    public $provinsi_id;

    public function validateSave()
    {
        return $this->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'provinsi_id' => 'required|string'
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            'id' => 'required|string',
            'name' => 'required|string',
            'type' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'provinsi_id' => 'required|string'
        ]);
    }
}
