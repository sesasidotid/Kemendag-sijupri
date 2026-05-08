<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Eyegil\SijupriMaintenance\Models\SystemConfiguration;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                    "type" => "select",
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

            SystemConfiguration::where("id", "UKOM_GRADE_IS_REPLACE")->delete();

            // SystemConfiguration::updateOrCreate(
            //     [
            //         "code" => "UKOM_GRADE_IS_REPLACE",
            //     ],
            //     [
            //         "type" => "json:select",
            //         "created_by" => "system",
            //         "date_created" => Carbon::now(),
            //         "name" => "ya untuk menimpa upload nilai dan tidak untuk diabaikan",
            //         "value" => json_encode([
            //             ExamTypes::CAT->name => "ya",
            //             ExamTypes::WAWANCARA->name => "ya",
            //             ExamTypes::SEMINAR->name => "ya",
            //             ExamTypes::PRAKTIK->name => "ya",
            //             ExamTypes::PORTOFOLIO->name => "ya",
            //             ExamTypes::MAKALAH->name => "ya",
            //         ]),
            //         "rule" => "^\{\"CAT\":\"(ya|tidak)\",\"WAWANCARA\":\"(ya|tidak)\",\"SEMINAR\":\"(ya|tidak)\",\"PRAKTIK\":\"(ya|tidak)\",\"PORTOFOLIO\":\"(ya|tidak)\",\"MAKALAH\":\"(ya|tidak)\"\}$",
            //     ]
            // );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKM_MAX_VIOLATION",
                ],
                [
                    "type" => "integer",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "jumlah pelanggaran maksimal saat ukom",
                    "value" => "3",
                    "rule" => "^\d+$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKM_MAUSE_AWAY_TIMEOUT",
                ],
                [
                    "type" => "integer",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "jumlah waktu maksimal mouse diluar layar sebelum dianggap melanggar (detik)",
                    "value" => "10",
                    "rule" => "^\d+$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKOM_SCHEDULE_IS_WEEKEN_ALLOWED",
                ],
                [
                    "type" => "select",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "atur ujian ukom boleh weekend",
                    "value" => "tidak",
                    "rule" => "^(ya|tidak)$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKOM_SCHEDULE_START_AT",
                ],
                [
                    "type" => "float",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "atur ujian ukom dimulai dari jam berapa",
                    "value" => "8",
                    "rule" => "^\d+(\.\d+)?$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKOM_SCHEDULE_END_AT",
                ],
                [
                    "type" => "float",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "atur ujian ukom berakhir pada jam berapa",
                    "value" => "17",
                    "rule" => "^\d+(\.\d+)?$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKOM_SCHEDULE_START_LUNCH_AT",
                ],
                [
                    "type" => "float",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "atur ujian ukom istirahat pada jam berapa",
                    "value" => "12",
                    "rule" => "^\d+(\.\d+)?$",
                ]
            );

            SystemConfiguration::updateOrCreate(
                [
                    "code" => "UKOM_SCHEDULE_END_LUNCH_AT",
                ],
                [
                    "type" => "float",
                    "created_by" => "system",
                    "date_created" => Carbon::now(),
                    "name" => "atur ujian ukom istirahat selesai pada jam berapa",
                    "value" => "13",
                    "rule" => "^\d+(\.\d+)?$",
                ]
            );

            Log::info("\n HFSHWYSJSK");
            Log::info(Crypt::encrypt(json_encode(["participant_ukom_id" => "bdbeb798-d01a-4895-a112-004e81093e59"])));
        });
    }
}
