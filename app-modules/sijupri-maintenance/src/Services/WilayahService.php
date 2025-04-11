<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\Wilayah;

class WilayahService
{
    public function findAll()
    {
        return Wilayah::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findByCode($code)
    {
        return Wilayah::findOrThrowNotFound($code);
    }
}
