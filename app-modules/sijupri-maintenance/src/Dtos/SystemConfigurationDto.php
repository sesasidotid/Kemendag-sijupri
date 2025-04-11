<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class SystemConfigurationDto extends BaseDto
{
    public $code;
    public $name;
    public $value;
    public $type;
    public $rule;

    public function validateSave()
    {
        return $this->validate([
            'code' => 'required|string',
            'value' => 'required|email',
        ]);
    }
}
