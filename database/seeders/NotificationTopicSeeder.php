<?php

namespace Database\Seeders;

use App\Enums\NotificationCode;
use App\Enums\NotificationTopicCode;
use Eyegil\NotificationBase\Models\NotificationTopic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTopicSeeder extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {

            NotificationTopic::updateOrCreate(
                [
                    "code" => NotificationTopicCode::VERIFY_SIAP,
                ],
                [
                    "topic" => "verifikasi data siap",
                    "role_code" => "USER_UNIT_KERJA",
                ]
            );

            NotificationTopic::updateOrCreate(
                [
                    "code" => NotificationTopicCode::VERIFY_SIAP_KINERJA,
                ],
                [
                    "topic" => "verifikasi data siap",
                    "role_code" => "ADMIN_PAK",
                ]
            );

            NotificationTopic::updateOrCreate(
                [
                    "code" => NotificationTopicCode::VERIFY_AKP,
                ],
                [
                    "topic" => "verifikasi dokumen formasi",
                    "role_code" => "ADMIN_AKP",
                ]
            );

            NotificationTopic::updateOrCreate(
                [
                    "code" => NotificationTopicCode::VERIFY_FORMASI,
                ],
                [
                    "topic" => "verifikasi registrasi formasi",
                    "role_code" => "ADMIN_FORMASI",
                ]
            );

            NotificationTopic::updateOrCreate(
                [
                    "code" => NotificationTopicCode::REJECT_FORMASI,
                ],
                [
                    "topic" => "tolak dokumen formasi",
                    "role_code" => "USER_UNIT_KERJA",
                ]
            );

            NotificationTopic::updateOrCreate(
                [
                    "code" => NotificationTopicCode::INVITE_FORMASI,
                ],
                [
                    "topic" => "invite formasi",
                    "role_code" => "USER_UNIT_KERJA",
                ]
            );

            NotificationTopic::updateOrCreate(
                [
                    "code" => NotificationTopicCode::VERIFY_UKOM,
                ],
                [
                    "topic" => "verifikasi registrasi ukom",
                    "role_code" => "ADMIN_UKOM",
                ]
            );
        });
    }
}
