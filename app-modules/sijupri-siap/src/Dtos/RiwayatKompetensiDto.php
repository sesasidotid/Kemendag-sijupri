<?php

namespace Eyegil\SijupriSiap\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class RiwayatKompetensiDto extends BaseDto
{
    public $id;
    public $name;
    public $date_start;
    public $date_end;
    public $tgl_sertifikat;
    public $sertifikat;
    public $sertifikat_url;
    public $file_sertifikat;
    public $kategori_pengembangan_id;
    public $kategori_pengembangan_name;
    public $kategori_pengembangan_value;
    public $nip;

    public function validateSave()
    {
        return $this->validate([
            'name' => 'required|string',
            'date_start' => 'required|string',
            'date_end' => 'required|string',
            'tgl_sertifikat' => 'required|string',
            'file_sertifikat' => 'required',
            'kategori_pengembangan_id' => 'required',
        ]);
    }

    public function validateTask()
    {
        return $this->validate([
            'name' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'tgl_sertifikat' => 'required',
            'sertifikat' => 'required',
            'sertifikat_url' => 'required',
            'kategori_pengembangan_id' => 'required',
            'kategori_pengembangan_name' => 'required',
            'kategori_pengembangan_value' => 'required',
        ]);
    }
}
