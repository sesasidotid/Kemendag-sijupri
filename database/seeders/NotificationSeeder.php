<?php

namespace Database\Seeders;

use App\Enums\NotificationCode;
use App\Enums\NotificationTemplateCode;
use Eyegil\NotificationBase\Models\NotificationTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_SIAP,
                ],
                [
                    "template" => "Halo,\n\n\$siap_type anda telah diverifikasi.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_REJECT_SIAP,
                ],
                [
                    "template" => "Halo,\n\n\$siap_type anda telah ditolak.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_VERIFY_SIAP,
                ],
                [
                    "template" => "Halo,\n\nAnda menerima permintaan verifikasi SIAP baru.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_VERIFY_FORMASI,
                ],
                [
                    "template" => "Halo,\n\nAnda menerima permintaan verifikasi formasi baru.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_REJECT_FORMASI,
                ],
                [
                    "template" => "Halo,\n\nDokumen formasi anda ditolak.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_INVITE_FORMASI,
                ],
                [
                    "template" => "Halo,\n\nAnda menerima undangan verifikasi formasi baru.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_FINISH_FORMASI,
                ],
                [
                    "template" => "Halo,\n\nFormasi telah selesai.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_VERIFY_AKP,
                ],
                [
                    "template" => "Halo,\n\nAnda menerima permintaan verifikasi akp baru.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_REJECT_AKP,
                ],
                [
                    "template" => "Halo,\n\nPermintaan AKP anda ditolak.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_AKP_PERSONAL,
                ],
                [
                    "template" => "Halo,\n\nMohon melakukan penilaian akp personal.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_VERIFY_UKOM,
                ],
                [
                    "template" => "Halo,\n\nAnda menerima undangan verifikasi formasi baru.",
                    "parent_code" => null,
                    "notification_code" => NotificationCode::FIREBASE
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_AKP_ATASAN,
                ],
                [
                    "template" => '<!DOCTYPE html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Email Penilaian AKP</title>    <style>        body {            font-family: Arial, sans-serif;            margin: 0;            padding: 0;            background-color: #f4f4f4;        }        .email-container {            width: 100%;            max-width: 600px;            margin: 0 auto;            background-color: #ffffff;            padding: 20px;            box-sizing: border-box;            border-radius: 8px;            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);        }        .email-header {            text-align: left;            padding-bottom: 20px;            border-bottom: 1px solid #eeeeee;        }        .email-header h1 {            color: #333333;            font-size: 24px;        }        .email-content {            margin-top: 20px;            text-align: left;        }        .email-content p {            font-size: 16px;            color: #555555;        }        .btn {            display: inline-block;            padding: 12px 25px;            margin-top: 20px;            background-color: #007bff;            color: #ffffff;            text-decoration: none;            border-radius: 5px;            font-size: 16px;            margin: 10px 0;        }        .btn:hover {            background-color: #0056b3;        }        .btn-secondary {            background-color: #28a745;        }        .btn-secondary:hover {            background-color: #218838;        }    </style></head><body>    <div class="email-container">        <div class="email-header">            <h1>Halo, $nama_atasan</h1>        </div>        <div class="email-content">            <p>Untuk melanjutkan, kami mengundang Anda untuk melakukan penilaian AKP. Pilih tombol sesuai dengan jenis penilaian yang akan Anda lakukan:</p>             <a href="$atasan_url" class="btn">Penilaian Atasan</a>             <a href="$rekan_url" class="btn btn-secondary">Penilaian Rekan</a>        </div>    </div></body></html>',
                    "parent_code" => null,
                    "notification_code" => NotificationCode::SMTP
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_UKOM_REG_FINISHED,
                ],
                [
                    "template" => '<!DOCTYPE html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Email Selesai Registrasi Ukom</title>    <style>        body {            font-family: Arial, sans-serif;            margin: 0;            padding: 0;            background-color: #f4f4f4;        }        .email-container {            width: 100%;            max-width: 600px;            margin: 0 auto;            background-color: #ffffff;            padding: 20px;            box-sizing: border-box;            border-radius: 8px;            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);        }        .email-header {            text-align: left;            padding-bottom: 20px;            border-bottom: 1px solid #eeeeee;        }        .email-header h1 {            color: #333333;            font-size: 24px;        }        .email-content {            margin-top: 20px;            text-align: left;        }        .email-content p {            font-size: 16px;            color: #555555;        }        .btn {            display: inline-block;            padding: 12px 25px;            margin-top: 20px;            background-color: #ff0000;            color: #ffffff;            text-decoration: none;            border-radius: 5px;            font-size: 16px;            margin: 10px 0;        }        .btn:hover {            background-color: #b34b00;        }        .btn-secondary {            background-color: #28a745;        }        .btn-secondary:hover {            background-color: #218838;        }    </style></head><body>    <div class="email-container">        <div class="email-header">            <h1>Halo, $name</h1>        </div>        <div class="email-content">            <p>Pendaftaran UKom anda telah diterima. Mohon kesediaan anda untuk mengikuti ujian pada tanggal berikut:            </p>            <table>                <tr>                    <td>Tanggal Mulai</td>                    <td>: $date_start</td>                </tr>                <tr>                    <td>Tanggal Selesai</td>                    <td>: $date_end</td>                </tr>            </table>            <a href="$detail_page_url" class="btn">Ingin Membatalkan</a>        </div>    </div></body></html>',
                    "parent_code" => null,
                    "notification_code" => NotificationCode::SMTP
                ]
            );

            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::NOTIFY_UKOM_REG_NON_JF,
                ],
                [
                    "template" => '<!DOCTYPE html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Pendaftaran UKom</title>    <style>        body {            font-family: Arial, sans-serif;            margin: 0;            padding: 0;            background-color: #f4f4f4;        }        .email-container {            width: 100%;            max-width: 600px;            margin: 0 auto;            background-color: #ffffff;            padding: 20px;            box-sizing: border-box;            border-radius: 8px;            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);        }        .email-header {            text-align: left;            padding-bottom: 20px;            border-bottom: 1px solid #eeeeee;        }        .email-header h1 {            color: #333333;            font-size: 24px;        }        .email-content {            margin-top: 20px;            text-align: left;        }        .email-content p {            font-size: 16px;            color: #555555;        }        .btn {            display: inline-block;            padding: 12px 25px;            margin-top: 20px;            background-color: #ff0000;            color: #ffffff;            text-decoration: none;            border-radius: 5px;            font-size: 16px;            margin: 10px 0;        }        .btn:hover {            background-color: #b34b00;        }        .btn-secondary {            background-color: #28a745;        }        .btn-secondary:hover {            background-color: #218838;        }        /* Center the image */        .email-content img {            display: block;            margin: 20px auto;            max-width: 100%;        }    </style></head><body>    <div class="email-container">        <div class="email-header">            <h1>Halo, $name</h1>        </div>        <div class="email-content">            <p>Selamat anda telah berhasil mendaftar uji kompetensi JF Perdagangan Tahun $year. Gunakan kode atau qr                code berikut untuk mengetahui proses selanjutnya.</p>            <a href="$page_url">                $page_url            </a>            <img src="$image_url"                alt="QR Code">        </div>    </div></body></html>',
                    "parent_code" => null,
                    "notification_code" => NotificationCode::SMTP
                ]
            );
            
            NotificationTemplate::updateOrCreate(
                [
                    "code" => NotificationTemplateCode::FORGOT_PASSWORD,
                ],
                [
                    "template" => '<!DOCTYPE html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Pendaftaran UKom</title>    <style>        body {            font-family: Arial, sans-serif;            margin: 0;            padding: 0;            background-color: #f4f4f4;        }        .email-container {            width: 100%;            max-width: 600px;            margin: 0 auto;            background-color: #ffffff;            padding: 20px;            box-sizing: border-box;            border-radius: 8px;            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);        }        .email-header {            text-align: left;            padding-bottom: 20px;            border-bottom: 1px solid #eeeeee;        }        .email-header h1 {            color: #333333;            font-size: 24px;        }        .email-content {            margin-top: 20px;            text-align: left;        }        .email-content p {            font-size: 16px;            color: #555555;        }        .btn {            display: inline-block;            padding: 12px 25px;            margin-top: 20px;            background-color: #ff0000;            color: #ffffff;            text-decoration: none;            border-radius: 5px;            font-size: 16px;            margin: 10px 0;        }        .btn:hover {            background-color: #b34b00;        }        .btn-secondary {            background-color: #28a745;        }        .btn-secondary:hover {            background-color: #218838;        }        /* Center the image */        .email-content img {            display: block;            margin: 20px auto;            max-width: 100%;        }    </style></head><body>    <div class="email-container">        <div class="email-header">            <h1>Halo, $name</h1>        </div>        <div class="email-content">            <p>Selamat anda telah berhasil mendaftar uji kompetensi JF Perdagangan Tahun $year. Gunakan kode atau qr                code berikut untuk mengetahui proses selanjutnya.</p>            <a href="$page_url">                $page_url            </a>            <img src="$image_url"                alt="QR Code">        </div>    </div></body></html><!DOCTYPE html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Pendaftaran UKom</title>    <style>        body {            font-family: Arial, sans-serif;            margin: 0;            padding: 0;            background-color: #f4f4f4;        }        .email-container {            width: 100%;            max-width: 600px;            margin: 0 auto;            background-color: #ffffff;            padding: 20px;            box-sizing: border-box;            border-radius: 8px;            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);        }        .email-header {            text-align: left;            padding-bottom: 20px;            border-bottom: 1px solid #eeeeee;        }        .email-header h1 {            color: #333333;            font-size: 24px;        }        .email-content {            margin-top: 20px;            text-align: left;        }        .email-content p {            font-size: 16px;            color: #555555;        }        .btn {            display: inline-block;            padding: 12px 25px;            margin-top: 20px;            background-color: #ff0000;            color: #ffffff;            text-decoration: none;            border-radius: 5px;            font-size: 16px;            margin: 10px 0;        }        .btn:hover {            background-color: #b34b00;        }        .btn-secondary {            background-color: #28a745;        }        .btn-secondary:hover {            background-color: #218838;        }        /* Center the image */        .email-content img {            display: block;            margin: 20px auto;            max-width: 100%;        }    </style></head><body>    <div class="email-container">        <div class="email-header">            <h1>Halo, $name</h1>        </div>        <div class="email-content">            <p>Klik url di bawah ini untuk mengubah password anda. jikalau anda tidak mengingat melakukan perintah ini silahkan untuk mengabaikan perintah ini.</p> <a href="$page_url"> $page_url </a>         </div>    </div></body></html>',
                    "parent_code" => null,
                    "notification_code" => NotificationCode::SMTP
                ]
            );
        });
    }
}
