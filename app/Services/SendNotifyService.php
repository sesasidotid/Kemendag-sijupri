<?php

namespace App\Services;

use App\Enums\NotificationTemplateCode;
use App\Enums\NotificationTopicCode;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\NotificationBase\Services\NotificationService;
use Eyegil\NotificationFirebase\Services\FirebaseMessageTokenService;
use Eyegil\SecurityBase\Services\DeviceService;
use Eyegil\SecurityBase\Services\UserRoleService;
use Eyegil\SijupriSiap\Models\UserUnitKerja;
use Eyegil\SijupriSiap\Services\JFService;
use Eyegil\SijupriSiap\Services\UserUnitKerjaService;

class SendNotifyService
{

    public function __construct(
        private NotificationService $notificationService,
        private DeviceService $deviceService,
        private FirebaseMessageTokenService $firebaseMessageTokenService,
        private JFService $jFService,
        private UserUnitKerjaService $userUnitKerjaService,
        private UserRoleService $userRoleService
    ) {}

    public function notifyProfile(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Profile Telah Diverifikasi";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "profile";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_SIAP->value, $notificationDto);
    }

    public function notifyRwPendidikan(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Pendidikan Telah Diverifikasi";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_pendidikan";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_SIAP->value, $notificationDto);
    }

    public function notifyRejectRwPendidikan(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Pendidikan Telah Ditolak";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_pendidikan";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_REJECT_SIAP->value, $notificationDto);
    }

    public function notifyRwPangkat(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Pangkat Telah Diverifikasi";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_pangkat";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_SIAP->value, $notificationDto);
    }

    public function notifyRejectRwPangkat(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Pangkat Telah Ditolak";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_pangkat";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_REJECT_SIAP->value, $notificationDto);
    }

    public function notifyRwJabatan(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Jabatan Telah Diverifikasi";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_jabatan";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_SIAP->value, $notificationDto);
    }

    public function notifyRejectRwJabatan(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Jabatan Telah Ditolak";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_jabatan";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_REJECT_SIAP->value, $notificationDto);
    }

    public function notifyRwKinerja(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Kinerja Telah Diverifikasi";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_kinerja";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_SIAP->value, $notificationDto);
    }

    public function notifyRejectRwKinerja(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Kinerja Telah Ditolak";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_kinerja";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_REJECT_SIAP->value, $notificationDto);
    }

    public function notifyRwKompetensi(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Kompetensi Telah Diverifikasi";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_kompetensi";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_SIAP->value, $notificationDto);
    }

    public function notifyRejectRwKompetensi(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Kompetensi Telah Ditolak";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_kompetensi";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_REJECT_SIAP->value, $notificationDto);
    }

    public function notifyRwSertifikasi(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Sertifikasi Telah Diverifikasi";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_sertifikasi";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_SIAP->value, $notificationDto);
    }

    public function notifyRejectRwSertifikasi(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Riwayat Sertifikasi Telah Ditolak";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "rw_sertifikasi";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_REJECT_SIAP->value, $notificationDto);
    }

    public function notifyRejectAkp(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Permintaan AKP Telah Ditolak";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "akp";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_REJECT_AKP->value, $notificationDto);
    }

    public function notifyPenilaianPersonalAkp(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Penilaian AKP personal";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "akp";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_AKP_PERSONAL->value, $notificationDto);
    }

    public function notifyRejectUkom(NotificationDto $notificationDto, $nip)
    {
        $notificationDto->subject = "Dokumen UKom Telah Ditolak";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "ukom";
        $this->notificationService->sendToUserIds("firebase", [$nip], NotificationTemplateCode::NOTIFY_REJECT_UKOM->value, $notificationDto);
    }

    // SMTP WITH TOPIC
    public function notifyVerifySIAP(NotificationDto $notificationDto)
    {
        $notificationDto->subject = "Verifikasi SIAP";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "siap";
        $this->notificationService->sendToTopic("firebase", NotificationTopicCode::VERIFY_SIAP->value, NotificationTemplateCode::NOTIFY_VERIFY_SIAP->value, $notificationDto);
    }

    public function notifyVerifySIAPKinerja(NotificationDto $notificationDto)
    {
        $notificationDto->subject = "Verifikasi SIAP";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "siap";
        $this->notificationService->sendToTopic("firebase", NotificationTopicCode::VERIFY_SIAP_KINERJA->value, NotificationTemplateCode::NOTIFY_VERIFY_SIAP->value, $notificationDto);
    }

    public function notifyVerifyAkp(NotificationDto $notificationDto)
    {
        $notificationDto->subject = "Verifikasi AKP";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "akp";
        $this->notificationService->sendToTopic("firebase", NotificationTopicCode::VERIFY_AKP->value, NotificationTemplateCode::NOTIFY_VERIFY_AKP->value, $notificationDto);
    }

    public function notifyVerifyFormasi(NotificationDto $notificationDto)
    {
        $notificationDto->subject = "Verifikasi Formasi";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "formasi";
        $this->notificationService->sendToTopic("firebase", NotificationTopicCode::VERIFY_FORMASI->value, NotificationTemplateCode::NOTIFY_VERIFY_FORMASI->value, $notificationDto);
    }

    public function notifyInviteFormasi(NotificationDto $notificationDto)
    {
        $notificationDto->subject = "Invitation Formasi";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "formasi";
        $this->notificationService->sendToTopic("firebase", NotificationTopicCode::INVITE_FORMASI->value, NotificationTemplateCode::NOTIFY_INVITE_FORMASI->value, $notificationDto);
    }

    public function notifyRejectFormasi(NotificationDto $notificationDto)
    {
        $notificationDto->subject = "Dokumen Formasi Telah Ditolak";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "formasi";
        $this->notificationService->sendToTopic("firebase", NotificationTopicCode::REJECT_FORMASI->value, NotificationTemplateCode::NOTIFY_REJECT_FORMASI->value, $notificationDto);
    }

    public function notifyVerifyUkom(NotificationDto $notificationDto)
    {
        $notificationDto->subject = "Verifikasi UKom";
        $notificationDto->additionalData = $notificationDto->additionalData ?? [];
        $notificationDto->additionalData['category'] = "formasi";
        $this->notificationService->sendToTopic("firebase", NotificationTopicCode::VERIFY_UKOM->value, NotificationTemplateCode::NOTIFY_VERIFY_UKOM->value, $notificationDto);
    }

    //EMAIL
    public function sendEmailAkpAtasan(NotificationDto $notificationDto, $email)
    {
        $notificationDto->subject = "Penilaian AKP";
        $this->notificationService->sendTo("smtp", [$email], NotificationTemplateCode::NOTIFY_AKP_ATASAN->value, $notificationDto);
    }

    public function sendEmailFinishUkomRegistration(NotificationDto $notificationDto, $email)
    {
        $notificationDto->subject = "Registrasi Ukom";
        $this->notificationService->sendTo("smtp", [$email], NotificationTemplateCode::NOTIFY_UKOM_REG_FINISHED->value, $notificationDto);
    }

    public function sendEmailUkomRegistration(NotificationDto $notificationDto, $email)
    {
        $notificationDto->subject = "Registrasi Ukom";
        $this->notificationService->sendTo("smtp", [$email], NotificationTemplateCode::NOTIFY_UKOM_REG_NON_JF->value, $notificationDto);
    }
}
