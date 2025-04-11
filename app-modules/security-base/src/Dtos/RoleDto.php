<?php

namespace Eyegil\SecurityBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class RoleDto extends BaseDto
{
    public $code;
    public $name;
    public $description;
    public $is_creatable;
    public $is_updatable;
    public $is_deletable;
    public $application_code;
    public $menu_code_list;

    public function validateUpdate()
    {
        return $this->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'is_creatable' => 'nullable|bool',
            'is_updatable' => 'nullable|bool',
            'is_deletable' => 'nullable|bool',
            'application_code' => 'required|string',
            'menu_code_list' => 'required|array',
        ]);
    }

    public function validateSave()
    {
        return $this->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'is_creatable' => 'nullable|bool',
            'is_updatable' => 'nullable|bool',
            'is_deletable' => 'nullable|bool',
            'application_code' => 'required|string',
            'menu_code_list' => 'required|array',
        ]);
    }
}
