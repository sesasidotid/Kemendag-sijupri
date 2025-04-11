<?php

namespace Eyegil\SijupriFormasi\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class FormasiDetailDto extends BaseDto
{
    public $id;
    public $total;
    public $result;
    public $jabatan_code;
    public $jabatan_name;
    public $formasi_id;

    public array $formasi_result_dto_list;
    public array $formasi_score_dto_list;

    public array $unsur_dto_list;

    public function validateSave()
    {
        return $this->validate([
            "formasi_id" => "required|string",
            "jabatan_code" => "required|string",
            "unsur_dto_list" => "required|array",
        ]);
    }

    public function validateCalculate()
    {
        return $this->validate([
            "formasi_id" => "required|string",
            "jabatan_code" => "required|string",
            "unsur_dto_list" => "required|array",
        ]);
    }

    public function validateUpdateResult()
    {
        return $this->validate([
            "id" => "required",
            "formasi_result_dto_list" => "required"
        ]);
    }
}
