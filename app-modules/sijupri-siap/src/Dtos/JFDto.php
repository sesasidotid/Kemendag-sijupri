<?php

namespace Eyegil\SijupriSiap\Dtos;

use Eyegil\SecurityBase\Dtos\UserDto;
use Illuminate\Http\Request;

class JFDto extends UserDto
{
    public $nip;
    public $nik;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $ktp;
    public $ktp_url;
    public $file_ktp;
    public $jenis_kelamin_code;
    public $jenis_kelamin_name;
    public $unit_kerja_id;
    public $unit_kerja_name;
    public $instansi_id;
    public $instansi_name;
    public $pangkat_code;
    public $pangkat_name;
    public $jabatan_code;
    public $jabatan_name;
    public $jenjang_code;
    public $jenjang_name;

    public function validateSave()
    {
        return $this->validate([
            'nip' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'jenis_kelamin_code' => 'required|string',
        ]);
    }

    public function validateUpdate()
    {
        $validation = [
            'nip' => 'required|string',
            'nik' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'jenis_kelamin_code' => 'required|string',
        ];
        if (!$this->ktp_url)
            $validation["file_ktp"] = "required|string";

        return $this->validate($validation);
    }
}
