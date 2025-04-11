<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Models\Pendidikan;
use Illuminate\Support\Facades\DB;

class PendidikanService
{
    public function findAll()
    {
        return Pendidikan::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findById($id)
    {
        return Pendidikan::findOrThrowNotFound($id);
    }
}
