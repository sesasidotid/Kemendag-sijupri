<?php

namespace Database\Seeders;

use Eyegil\WorkflowBase\Models\ObjectTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataRefactor extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            ObjectTask::all()->each(function ($objectTask) {
                $objectTask->object = self::convertBooleans($objectTask->object);
                $objectTask->old_object = self::convertBooleans($objectTask->old_object);
                $objectTask->prev_object = self::convertBooleans($objectTask->prev_object);

                $objectTask->save();
            });
        });
    }

    private static function convertBooleans($data)
    {
        // Convert stdClass to array
        if ($data instanceof \stdClass) {
            $data = (array) $data;
        }

        // Skip anything that's still not array
        if (!is_array($data)) {
            return $data;
        }

        foreach ($data as $key => $value) {
            if ($value === "true") {
                $data[$key] = true;
            } elseif ($value === "false") {
                $data[$key] = false;
            }
        }

        return $data;
    }
}
