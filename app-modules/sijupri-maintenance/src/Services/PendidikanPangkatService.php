<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\PendidikanPangkat;

class PendidikanPangkatService
{
    public function findById($id)
    {
        return PendidikanPangkat::findOrThrowNotFound($id);
    }
}
