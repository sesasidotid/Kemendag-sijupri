<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\KategoriPengembangan;

class KategoriPengembanganService
{
    public function findAll()
    {
        return KategoriPengembangan::all();
    }

    public function findById($id)
    {
        return KategoriPengembangan::findOrThrowNotFound($id);
    }
}
