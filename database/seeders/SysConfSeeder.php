<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Eyegil\SijupriMaintenance\Models\SystemConfiguration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysConfSeeder extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKM_BAN",
                ],
                [
                    "type" => "integer",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "Ban participant ukom yang menolak (hari)",
                    "value" => "30",
                    "rule" => "^\d+$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKM_BAN_FAILED",
                ],
                [
                    "type" => "integer",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "Ban participant ukom yang tidak lulus (hari)",
                    "value" => "30",
                    "rule" => "^\d+$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKM_REGISTRATION",
                ],
                [
                    "type" => "integer",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "status aktif pendaftaran ukom (ya/tidak)",
                    "value" => "ya",
                    "rule" => "^(ya|tidak)$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "URL_CHANGE_PASSWORD",
                ],
                [
                    "type" => "integer",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "jumlah waktu kadaluarsa link update password (menit) |  taruh 0 untuk tanpa kadaluarsa",
                    "value" => "10",
                    "rule" => "^\d+$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "URL_NON_JF_UKOM",
                ],
                [
                    "type" => "integer",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "jumlah waktu kadaluarsa link detail pendaftaran non-jf (hari) | taruh 0 untuk tanpa kadaluarsa",
                    "value" => "3650",
                    "rule" => "^\d+$",
                ]
            );
        });
    }
}
