<?php

namespace Eyegil\SijupriFormasi\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class FormasiDto extends BaseDto
{
    public $id;
    public $formasi_status;
    public $unit_kerja_id;
    public $unit_kerja_name;
    public $waktu_pelaksanaan;
    public $rekomendasi;
    public $rekomendasi_url;
    public $file_rekomendasi;
    public $surat_undangan;
    public $surat_undangan_url;
    public $file_surat_undangan;

    public $formasi_detail_dto_list;

    public $formasi_dokumen_list;

    public function validateFlow2Approve()
    {
        return $this->validate([
            "file_surat_undangan" => "required|string",
        ]);
    }

    public function validateFlow2Reject()
    {
        return $this->validate([
            "formasi_dokumen_list" => "required|array",
        ]);
    }

    public function validateFlow3()
    {
        return $this->validate([
            "id" => "required|string",
            "formasi_detail_dto_list" => "required"
        ]);
    }

    public function validateFlow5()
    {
        return $this->validate(["file_rekomendasi" => "required|string"]);
    }
}
