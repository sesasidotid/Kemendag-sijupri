<?php

namespace Database\Seeders;

use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Models\ExamType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamTypeSeeder extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {

            ExamType::updateOrCreate(
                [
                    "code" => ExamTypes::CAT,
                ],
                [
                    "name" => ExamTypes::CAT->value,
                ]
            );

            ExamType::updateOrCreate(
                [
                    "code" => ExamTypes::WAWANCARA,
                ],
                [
                    "name" => ExamTypes::WAWANCARA->value,
                ]
            );

            ExamType::updateOrCreate(
                [
                    "code" => ExamTypes::SEMINAR,
                ],
                [
                    "name" => ExamTypes::SEMINAR->value,
                ]
            );

            ExamType::updateOrCreate(
                [
                    "code" => ExamTypes::PRAKTIK,
                ],
                [
                    "name" => ExamTypes::PRAKTIK->value,
                ]
            );

            ExamType::updateOrCreate(
                [
                    "code" => ExamTypes::PORTOFOLIO,
                ],
                [
                    "name" => ExamTypes::PORTOFOLIO->value,
                ]
            );

            ExamType::updateOrCreate(
                [
                    "code" => ExamTypes::MAKALAH,
                ],
                [
                    "name" => ExamTypes::MAKALAH->value,
                ]
            );

            ExamType::updateOrCreate(
                [
                    "code" => ExamTypes::STUDI_KASUS,
                ],
                [
                    "name" => ExamTypes::STUDI_KASUS->value,
                ]
            );
        });
    }
}
