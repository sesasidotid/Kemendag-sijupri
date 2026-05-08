<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Models\ExamType;
use Illuminate\Support\Facades\DB;

class ExamTypeService
{

    public function findAll()
    {
        return ExamType::whereNot("code", ExamTypes::SEMINAR)->get();
    }

    public function findByCode($id)
    {
        return ExamType::findOrThrowNotFound($id);
    }
}
