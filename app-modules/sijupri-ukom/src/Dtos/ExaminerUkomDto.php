<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\SecurityBase\Dtos\UserDto;

class ExaminerUkomDto extends UserDto
{
    public $id;
    public $name;
    public $jenis_kelamin_code;
    public $nip;

    public function validateSaveExaminer()
    {
        return $this->validate([
            "name" => "required|string",
            "nip" => "required|string",
            "password" => "required|string",
            "jenis_kelamin_code" => "required|string",
        ]);
    }

    public function validateUpdateExaminer()
    {
        return $this->validate([
            'id' => 'required|string',
            'name' => 'required|string',
            'nip' => 'required|string',
            'jenis_kelamin_code' => 'required|string',
        ]);
    }
}
