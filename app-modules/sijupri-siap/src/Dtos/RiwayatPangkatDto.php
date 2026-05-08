<?php

namespace Eyegil\SijupriSiap\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class RiwayatPangkatDto extends BaseDto
{
    public $id;
    public $tmt;
    public $file_sk_pangkat;
    public $sk_pangkat;
    public $sk_pangkat_url;
    public $pangkat_code;
    public $pangkat_name;
    public $nip;

    public function validateSave()
    {
        return $this->validate([
            'tmt' => 'required|string',
            'pangkat_code' => 'required|string',
            'file_sk_pangkat' => 'required',
        ]);
    }

    public function validateTask()
    {
        return $this->validate([
            'tmt' => 'required',
            'pangkat_code' => 'required',
            'pangkat_name' => 'required',
            'sk_pangkat_url' => 'required',
            'sk_pangkat' => 'required',
            'nip' => 'required',
        ]);
    }
}
