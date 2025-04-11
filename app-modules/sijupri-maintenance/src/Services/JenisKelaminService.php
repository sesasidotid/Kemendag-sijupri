<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\JenisKelamin;

class JenisKelaminService
{
    public function findAll()
    {
        return JenisKelamin::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findByCode($code)
    {
        return JenisKelamin::findOrThrowNotFound($code);
    }
}
