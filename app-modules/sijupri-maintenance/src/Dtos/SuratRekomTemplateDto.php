<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class SuratRekomTemplateDto extends BaseDto
{

    public $code;
    public array $parameters;

    public function validateSetUp()
    {
        return $this->validate([
            "code" => "required|string",
            "parameters" => "required",
        ]);
    }
}