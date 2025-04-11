<?php

namespace Eyegil\SijupriFormasi\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class FormasiDokumenDto extends BaseDto
{
    public $id;
    public $dokumen;
    public $dokumen_url;
    public $dokumen_file;
    public $dokumen_persyaratan_id;
    public $dokumen_persyaratan_name;
    public $dokumen_status;
    public $formasi_id;

    public function validateFlow2Reject()
    {
        return $this->validate([
            "dokumen_persyaratan_id" => "required"
        ]);
    }

    public function validateSaveDokumenPersyaratan()
    {
        return $this->validate([
            "dokumen_persyaratan_name" => "required"
        ]);
    }
}
