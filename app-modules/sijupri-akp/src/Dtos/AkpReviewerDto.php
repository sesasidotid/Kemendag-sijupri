<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class AkpReviewerDto extends BaseDto {

    public $id;
    public $nip;
    public $name;
    public $email;
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
    public $instrument_id;
    public $instrument_name;
    public array $kategori_instrument_list;
    public array $data_pertanyaan_list;
}