<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Eyegil\SijupriMaintenance\Models\SystemConfiguration;
use Eyegil\WorkflowBase\Models\ObjectTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class V2ObjectTaskMigration extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            $oldUrl = "";
            $currentUrl = env("APP_URL");

            foreach (ObjectTask::all() as $key => $objectTask) {
                $object = str_replace($oldUrl, $currentUrl, json_encode($objectTask->object));
                $old_object = str_replace($oldUrl, $currentUrl, json_encode($objectTask->old_object));
                $prev_object = str_replace($oldUrl, $currentUrl, json_encode($objectTask->prev_object));

                $objectTask->object = $object;
                $objectTask->old_object = $old_object;
                $objectTask->prev_object = $prev_object;
                $objectTask->save();
            }
        });
    }
}
