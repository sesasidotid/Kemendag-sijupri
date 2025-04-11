<?php

namespace Eyegil\SijupriSiap\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class RiwayatPendidikanDto extends BaseDto
{
    public $id;
    public $institusi_pendidikan;
    public $jurusan;
    public $tanggal_ijazah;
    public $ijazah;
    public $ijazah_url;
    public $file_ijazah;
    public $pendidikan_code;
    public $pendidikan_name;
    public $nip;

    public function validateSave()
    {
        return $this->validate([
            'institusi_pendidikan' => 'required|string',
            'jurusan' => 'required|string',
            'tanggal_ijazah' => 'required|string',
            'file_ijazah' => 'required',
            'pendidikan_code' => 'required|string',
        ]);
    }
}
