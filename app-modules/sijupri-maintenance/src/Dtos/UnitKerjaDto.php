<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class UnitKerjaDto extends BaseDto
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $alamat;
    public $file_rekomendasi_formasi;
    public $latitude;
    public $longitude;
    public $instansi_id;
    public $wilayah_code;

    public function validateSave()
    {
        return $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'alamat' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'instansi_id' => 'required|string',
            'wilayah_code' => 'required|string',
        ]);
    }
}
