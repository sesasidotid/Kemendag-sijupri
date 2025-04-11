<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\PredikatKinerja;

class PredikatKinerjaService
{
    public function findAll()
    {
        return PredikatKinerja::all();
    }

    public function findById($id)
    {
        return PredikatKinerja::findOrThrowNotFound($id);
    }
}
