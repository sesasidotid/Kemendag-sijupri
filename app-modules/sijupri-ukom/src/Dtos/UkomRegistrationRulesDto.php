<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class UkomRegistrationRulesDto extends BaseDto
{
    public $id;
    public $jenjang_code;
    public $jenis_ukom;
    public $angka_kredit_threshold;
    public $last_n_year;
    public $tmt_last_n_year;
    public $rating_hasil_id;
    public $rating_kinerja_id;
    public $predikat_kinerja_id;

    public function validateSave()
    {
        return $this->validate([
            "jenjang_code" => "required|string",
            "angka_kredit_threshold" => "required|numeric",
            "last_n_year" => "required|numeric",
            "rating_hasil_id" => "required|string",
            "rating_kinerja_id" => "required|string",
            "predikat_kinerja_id" => "required|string"
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            "id" => "required|string",
            "jenjang_code" => "required|string",
            "angka_kredit_threshold" => "required|numeric",
            "last_n_year" => "required|numeric",
            "rating_hasil_id" => "required|string",
            "rating_kinerja_id" => "required|string",
            "predikat_kinerja_id" => "required|string"
        ]);
    }
}
