<?php

namespace Database\Seeders;

use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Jobs\UkomGradeJob;
use Eyegil\SijupriUkom\Models\ExamGrade;
use Eyegil\SijupriUkom\Models\UkomGrade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReevaluateAll extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            ExamGrade::whereHas("examSchedule", function ($query) {
                $query->whereHas("roomUkom", function ($query) {
                    $query->where("inactive_flag", false)
                        ->where("delete_flag", false);
                })->where("exam_type_code", ExamTypes::CAT->value);
            })->chunkById(100, function ($examGrades) {

                    $examGradeIds = $examGrades->pluck('id');
                    $examScheduleIds = $examGrades->pluck('exam_schedule_id')->unique();

                    UkomGrade::whereIn("cat_grade_id", $examGradeIds)->update([
                        "cat_grade_id" => null,
                        "nb_cat" => null,
                    ]);

                    // Delete in bulk (faster, fewer events)
                    ExamGrade::whereIn("id", $examGradeIds)->delete();

                    // Dispatch jobs AFTER COMMIT (important!)
                    DB::afterCommit(function () use ($examScheduleIds) {
                        foreach ($examScheduleIds as $scheduleId) {
                            UkomGradeJob::dispatch([ExamTypes::CAT->value], $scheduleId);
                        }
                    });
                });
        });
    }
}
