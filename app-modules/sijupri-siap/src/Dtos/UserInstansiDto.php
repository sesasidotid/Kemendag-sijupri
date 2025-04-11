<?php

namespace Eyegil\SijupriSiap\Dtos;

use Eyegil\SecurityBase\Dtos\UserDto;
use Illuminate\Http\Request;

class UserInstansiDto extends UserDto
{
    public $nip;
    public $instansi_id;

    public function validateSave()
    {
        return $this->validate([
            'nip' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'instansi_id' => 'required|string',
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            'nip' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'instansi_id' => 'required|string',
        ]);
    }
}
