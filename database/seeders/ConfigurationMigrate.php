<?php

namespace Database\Seeders;

use Eyegil\SijupriUkom\Models\ExamConfiguration;
use Eyegil\SijupriUkom\Models\ExamQuestion;
use Eyegil\SijupriUkom\Models\ExamSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationMigrate extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            ExamSchedule::with('configuration')->get()->each(function (ExamSchedule $examSchedule) {
                if (!$examSchedule->configuration) {
                    $examSchedule->configuration = new ExamConfiguration();
                    $examSchedule->configuration->exam_schedule_id = $examSchedule->id;
                    $examSchedule->configuration->saveWithUUid();
                }
            });
        });
    }
}
