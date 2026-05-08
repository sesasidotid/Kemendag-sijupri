<?php

namespace Database\Seeders;

use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Jobs\UkomGradeJob;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public static function run(): void
    {
        UkomGradeJob::dispatch([ExamTypes::CAT->value], "e569a609-3225-4779-ab8a-7d8b9272f957");
        UkomGradeJob::dispatch([ExamTypes::CAT->value], "dd5cc196-6ee1-43bb-84e2-5fdc6a18ece4");
        UkomGradeJob::dispatch([ExamTypes::CAT->value], "a14944a6-3e52-486c-9278-528ab9d44630");
    }
}
