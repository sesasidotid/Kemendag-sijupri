<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class DocumentUkomDto extends BaseDto
{
    public $id;
    public $dokumen;
    public $dokumen_url;
    public $dokumen_file;
    public $dokumen_persyaratan_id;
    public $dokumen_persyaratan_name;
    public $dokumen_status;
    public $jenis_ukom;
    public $jabatan_code;
    public $jabatan_name;
    public $jenjang_code;
    public $jenjang_name;
    public $is_mengulang;
    public $participant_ukom_id;

    public $remark;

    public function validateFlow1Reject()
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
