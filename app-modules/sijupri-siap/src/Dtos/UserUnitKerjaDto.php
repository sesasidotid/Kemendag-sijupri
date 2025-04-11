<?php

namespace Eyegil\SijupriSiap\Dtos;

use Eyegil\SecurityBase\Dtos\UserDto;
use Illuminate\Http\Request;

class UserUnitKerjaDto extends UserDto
{
    public $nip;
    public $unit_kerja_id;

    public function validateSave()
    {
        return $this->validate([
            'nip' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'unit_kerja_id' => 'required|string',
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            'nip' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'unit_kerja_id' => 'required|string',
        ]);
    }
}
