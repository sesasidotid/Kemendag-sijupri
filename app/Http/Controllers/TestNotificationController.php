<?php

namespace App\Http\Controllers;

use App\Services\SendNotifyService;
use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Illuminate\Http\Request;

#[Controller("/api/v1/test_notify")]
class TestNotificationController
{

    public function __construct(
        private SendNotifyService $sendNotifyService,
    ) {}


    #[Post("/profile")]
    public function notifyProfile(Request $request)
    {
        $request->validate(["nip" => "required"]);

        $notificationDto = new NotificationDto();
        $notificationDto->objectMap = [
            "name" => "My dummy name",
            "siap_type" => "Profile"
        ];
        $this->sendNotifyService->notifyProfile($notificationDto, $request->nip);
    }

    #[Post("/rw_pendidikan")]
    public function notifyRwPendidikan(Request $request)
    {
        $request->validate(["nip" => "required"]);

        $notificationDto = new NotificationDto();
        $notificationDto->objectMap = [
            "name" => "My dummy name",
            "siap_type" => "Riwayat pendidikan"
        ];
        $this->sendNotifyService->notifyRwPendidikan($notificationDto, $request->nip);
    }

    #[Post("/rw_pangkat")]
    public function notifyRwPangkat(Request $request)
    {
        $request->validate(["nip" => "required"]);

        $notificationDto = new NotificationDto();
        $notificationDto->objectMap = [
            "name" => "My dummy name",
            "siap_type" => "Riwayat pangkat"
        ];
        $this->sendNotifyService->notifyRwPangkat($notificationDto, $request->nip);
    }

    #[Post("/rw_jabatan")]
    public function notifyRwJabatan(Request $request)
    {
        $request->validate(["nip" => "required"]);

        $notificationDto = new NotificationDto();
        $notificationDto->objectMap = [
            "name" => "My dummy name",
            "siap_type" => "Riwayat jabatan"
        ];
        $this->sendNotifyService->notifyRwJabatan($notificationDto, $request->nip);
    }

    #[Post("/rw_kinerja")]
    public function notifyRwKinerja(Request $request)
    {
        $request->validate(["nip" => "required"]);

        $notificationDto = new NotificationDto();
        $notificationDto->objectMap = [
            "name" => "My dummy name",
            "siap_type" => "Riwayat kinerja"
        ];
        $this->sendNotifyService->notifyRwKinerja($notificationDto, $request->nip);
    }

    #[Post("/rw_kompetensi")]
    public function notifyRwKompetensi(Request $request)
    {
        $request->validate(["nip" => "required"]);

        $notificationDto = new NotificationDto();
        $notificationDto->objectMap = [
            "name" => "My dummy name",
            "siap_type" => "Riwayat kompetensi"
        ];
        $this->sendNotifyService->notifyRwKompetensi($notificationDto, $request->nip);
    }

    #[Post("/rw_sertifikasi")]
    public function notifyRwSertifikasi(Request $request)
    {
        $request->validate(["nip" => "required"]);

        $notificationDto = new NotificationDto();
        $notificationDto->objectMap = [
            "name" => "My dummy name",
            "siap_type" => "Riwayat sertifikasi"
        ];
        $this->sendNotifyService->notifyRwSertifikasi($notificationDto, $request->nip);
    }

    #[Post("/verify/siap")]
    public function notifyVerifySIAP(Request $request)
    {
        $request->validate(["nip" => "required"]);

        $notificationDto = new NotificationDto();
        $notificationDto->objectMap = [
            "name" => "My dummy name",
        ];
        $this->sendNotifyService->notifyVerifySIAP($notificationDto);
    }
}
