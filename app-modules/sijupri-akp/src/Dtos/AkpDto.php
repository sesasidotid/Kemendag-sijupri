<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class AkpDto extends BaseDto
{
    public $id;
    public $nip;
    public $name;
    public $tempat_lahir;
    public $tanggal_lahir;
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
    public $nama_atasan;
    public $email_atasan;
    public $action;
    public $rekomendasi;
    public $rekomendasi_url;
    public $rekomendasi_file;
    public array $matrix_dto_list;
    public array $matrix1_dto_list;
    public array $matrix2_dto_list;
    public array $matrix3_dto_list;
    public array $akp_rekap_dto_list;
    public $is_atasan_graded;
    public $is_rekan_graded;

    public $date_created;
    public $created_by;
    public $last_updated;
    public $updated_by;

    public function validateFlow1()
    {
        return $this->validate([
            "nama_atasan" => "required|string",
            "email_atasan" => "required|email",
        ]);
    }

    public function validateFlow4()
    {
        return $this->validate([
            "rekomendasi_file" => "required|string",
        ]);
    }
}
