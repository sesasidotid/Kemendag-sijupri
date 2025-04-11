<?php

namespace Eyegil\SecurityBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class UserDto extends BaseDto
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $user_details;
    public $status;
    public $role_code_list;
    public $password;
    public $application_code;
    public $channel_code_list;

    public function validateSave()
    {
        return $this->validate([
            'id' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'channel_code_list' => 'required|array',
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);
    }
}
