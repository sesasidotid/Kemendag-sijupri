<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\RatingKinerja;

class RatingKinerjaService
{
    public function findAll()
    {
        return RatingKinerja::all();
    }

    public function findById($id)
    {
        return RatingKinerja::findOrThrowNotFound($id);
    }
}
