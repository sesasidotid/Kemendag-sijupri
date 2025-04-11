<?php

namespace Eyegil\SijupriSiap\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class RiwayatJabatanDto extends BaseDto
{
    public $id;
    public $tmt;
    public $file_sk_jabatan;
    public $sk_jabatan;
    public $sk_jabatan_url;
    public $jabatan_code;
    public $jabatan_name;
    public $jenjang_code;
    public $jenjang_name;
    public $nip;

    public function validateSave()
    {
        return $this->validate([
            'tmt' => 'required|string',
            'jabatan_code' => 'required|string',
            'jenjang_code' => 'required|string',
            'file_sk_jabatan' => 'required',
        ]);
    }
}
