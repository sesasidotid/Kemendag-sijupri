<?php

namespace Eyegil\SijupriAkp\Services;

use Eyegil\SijupriAkp\Models\Instrument;

class InstrumentService
{
    public function findById($id): ?Instrument
    {
        return Instrument::findOrThrowNotFound($id);
    }

    public function findByJabatanJenjangId($jabatan_jenjang_id): ?Instrument
    {
        return Instrument::where('jabatan_jenjang_id', $jabatan_jenjang_id)->firstOrThrowNotFound();
    }

    public function findAll()
    {
        return Instrument::all();
    }
}
