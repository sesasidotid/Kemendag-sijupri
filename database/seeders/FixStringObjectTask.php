<?php

namespace Database\Seeders;

use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\ObjectTask;
use Eyegil\WorkflowBase\Models\PendingTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixStringObjectTask extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            ObjectTask::all()->each(function (ObjectTask $objectTask) {
                if (is_string($objectTask->object)) {
                    $decodedObject = json_decode($objectTask->object, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $objectTask->object = $decodedObject;
                        $objectTask->save();
                    }
                }
            });
        });
    }
}
