<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\SijupriUkom\Models\ExamType;
use Illuminate\Support\Facades\DB;

class ExamTypeService
{

    public function findAll()
    {
        return ExamType::All();
    }

    public function findByCode($id)
    {
        return ExamType::findOrThrowNotFound($id);
    }
}
