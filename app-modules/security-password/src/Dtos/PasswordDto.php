<?php

namespace Eyegil\SecurityPassword\Dtos;

use Eyegil\Base\Dtos\BaseDto;


class PasswordDto extends BaseDto
{
    public $user_id;
    public $password;
    public $old_password;

    public function validateUpdate()
    {
        return $this->validate([
            'user_id' => 'required',
            'password' => 'required',
            'old_password' => 'required',
        ]);
    }

    public function validateForgotPassword()
    {
        return $this->validate([
            'password' => 'required',
        ]);
    }
}
