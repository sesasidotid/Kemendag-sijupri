<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class PertanyaanDto extends BaseDto
{
    public $id;
    public $name;
    public $kategori_instrument_id;

    public function validateSave()
    {
        return $this->validate([
            'name' => 'required|string',
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            'name' => 'required|string',
        ]);
    }
}
