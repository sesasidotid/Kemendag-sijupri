<?php

namespace Database\Seeders;

use Eyegil\SijupriUkom\Models\ExamAttendance;
use Eyegil\SijupriUkom\Models\ExamGrade;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\PendingTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateExamWithSchedule extends Seeder
{
    public static function run(): void
    {
        ExamGrade::all()->each(function (ExamGrade $examGrade) {
            $examSchedule = DB::table("ukm_exam_schedule")
                ->where("exam_type_code", $examGrade->exam_type_code)
                ->where("room_ukom_id", $examGrade->room_ukom_id)
                ->first();

            if ($examSchedule) {
                $examGrade->exam_schedule_id = $examSchedule->id;
                $examGrade->save();
            }
        });

        ExamAttendance::all()->each(function (ExamAttendance $examAttendance) {
            $examSchedule = DB::table("ukm_exam_schedule")
                ->where("exam_type_code", $examAttendance->exam_type_code)
                ->where("room_ukom_id", $examAttendance->room_ukom_id)
                ->first();

            if ($examSchedule) {
                $examAttendance->exam_schedule_id = $examSchedule->id;
                $examAttendance->save();
            }
        });
    }
}
