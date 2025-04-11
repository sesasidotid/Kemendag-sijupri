<?php

namespace Eyegil\SijupriMaintenance\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class DokumenPersyaratanDto extends BaseDto
{
    public $id;
    public $name;
    public $association;
    public $additional_1;
    public $additional_2;
    public $additional_3;
    public $additional_4;
    public $additional_5;

    public function validateSave()
    {
        return $this->validate([
            'name' => 'required|string',
            'association' => 'required|string',
        ]);
    }
}
