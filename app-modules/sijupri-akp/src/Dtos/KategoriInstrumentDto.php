<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class KategoriInstrumentDto extends BaseDto
{
    public $id;
    public $name;
    public $instrument_id;
    public $instrument_name;
    public $pelatihan_teknis_id;
    public $pelatihan_teknis_name;
    public $pertanyaan_list;

    public function validateSave()
    {
        return $this->validate([
            'name' => 'required|string',
            'instrument_id' => 'required|numeric',
            'pelatihan_teknis_id' => 'required|string',
            'pertanyaan_list' => 'required',
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            'id' => 'required|numeric',
            'name' => 'required|string',
            'instrument_id' => 'required|numeric',
            'pelatihan_teknis_id' => 'required|string',
            'pertanyaan_list' => 'required',
        ]);
    }
}
