<?php

namespace Eyegil\SijupriFormasi\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class UnsurDto extends BaseDto
{
    public $id;
    public $unsur;
    public $lvl;
    public $jenjang_code;
    public $jenjang_name;
    public $jabatan_code;
    public $jabatan_name;
    public $parent_id;
    public $volume;
    public array $child;

    public function validateCalculate() {
        return $this->validate([
            "id" => "required",
            "volume" => "required",
        ]);
    }
}
