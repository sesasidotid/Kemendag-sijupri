<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\InstansiType;

class InstansiTypeService
{
    public function findAll()
    {
        return InstansiType::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findByCode($code)
    {
        return InstansiType::findOrThrowNotFound($code);
    }
}
