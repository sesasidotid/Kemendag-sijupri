<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\KategoriSertifikasi;

class KategoriSertifikasiService
{
    public function findAll()
    {
        return KategoriSertifikasi::all();
    }

    public function findById($id)
    {
        return KategoriSertifikasi::findOrThrowNotFound($id);
    }
}
