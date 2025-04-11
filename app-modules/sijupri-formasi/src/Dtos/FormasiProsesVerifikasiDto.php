<?php

namespace Eyegil\SijupriFormasi\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class FormasiProsesVerifikasiDto extends BaseDto
{
    public $id;
    public $waktu_pelaksanaan;
    public $surat_undangan;
    public $surat_undangan_url;
    public $file_surat_undangan;
    public $formasi_id;

    public function validateFlow2()
    {
        return $this->validate([
            "file_surat_undangan" => "required|string",
            "waktu_pelaksanaan" => "required|string",
        ]);
    }
}
