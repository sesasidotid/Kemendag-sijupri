<?php

namespace Database\Seeders;

use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\PendingTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UkomFailedRemark extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            $pendingTaskList = PendingTask::where("date_created", ">", "2025-09-01 00:00:00")
                ->where("task_status", TaskStatus::FAILED->name)->get();

            foreach ($pendingTaskList as $key => $pendingTask) {
                $prevPendingTask = PendingTask::where("instance_id", $pendingTask->instance_id)
                    ->where("date_created", "<", $pendingTask->date_created)
                    ->latest("date_created")
                    ->first();

                $pendingTask->remark = $prevPendingTask?->remark;
                $pendingTask->save();
            }
        });
    }
}
