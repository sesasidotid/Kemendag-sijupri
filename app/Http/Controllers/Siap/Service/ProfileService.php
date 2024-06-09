<?php

namespace App\Http\Controllers\Siap\Service;

use App\Enums\TaskStatus;
use App\Http\Controllers\SearchService;
use App\Models\Siap\UnitKerja;
use Illuminate\Support\Facades\DB;

class ProfileService extends UnitKerja
{
    use SearchService;
    
    private $userDetail;

    public function __construct()
    {
        $this->userDetail = new UserDetailService();
    }

    public function updateUserDetail(array $userDetailNew)
    {
        $this->userDetail->fill($userDetailNew);
        $this->userDetail->task_status = TaskStatus::PENDING;
        $this->userDetail->customSaveWithUpload($userDetailNew);
    }

    public function updateUserDetailWithoutFile(array $userDetailNew)
    {
        $this->userDetail->fill($userDetailNew);
        $this->userDetail->task_status = TaskStatus::PENDING;
        $this->userDetail->customSaveWithoutUpload();
    }

    public function updateUserPendidikan(array $userPendidikanNew)
    {
        DB::transaction(function () use ($userPendidikanNew) {
            $userPendidikan = new UserPendidikanService();
            if (isset($userPendidikanNew['id'])) {
                $userPendidikan = $userPendidikan->findById($userPendidikanNew['id']);
            }
            $userPendidikan->fill($userPendidikanNew);
            $userPendidikan->task_status = TaskStatus::PENDING;
            $userPendidikan->customSaveWithUpload($userPendidikanNew);
        });
    }

    public function updateUserJabatan(array $userJabatanNew)
    {
        DB::transaction(function () use ($userJabatanNew) {
            $userJabatan = new UserJabatanService();
            if (isset($userJabatanNew['id'])) {
                $userJabatan = $userJabatan->findById($userJabatanNew['id']);
            }
            $userJabatan->fill($userJabatanNew);
            $userJabatan->task_status = TaskStatus::PENDING;
            $userJabatan->customSaveWithUpload($userJabatanNew);
        });
    }

    public function updateUserPangkat(array $userPangkatNew)
    {
        DB::transaction(function () use ($userPangkatNew) {
            $userPangkat = new UserPangkatService();
            if (isset($userPangkatNew['id'])) {
                $userPangkat = $userPangkat->findById($userPangkatNew['id']);
            }
            $userPangkat->fill($userPangkatNew);
            $userPangkat->task_status = TaskStatus::PENDING;
            $userPangkat->customSaveWithUpload($userPangkatNew);
        });
    }

    public function updateUserPak(array $userPakNew)
    {
        DB::transaction(function () use ($userPakNew) {
            $userPak = new UserPakService();
            if (isset($userPakNew['id'])) {
                $userPak = $userPak->findById($userPakNew['id']);
            }
            $userPak->fill($userPakNew);
            $userPak->task_status = TaskStatus::PENDING;
            $userPak->customSaveWithUpload($userPakNew);
        });
    }

    public function updateUserKompetensi(array $userKompNew)
    {
        DB::transaction(function () use ($userKompNew) {
            $userKomp = new UserKompetensiService();
            if (isset($userKompNew['id'])) {
                $userKomp = $userKomp->findById($userKompNew['id']);
            }
            $userKomp->fill($userKompNew);
            $userKomp->task_status = TaskStatus::PENDING;
            $userKomp->customSaveWithUpload($userKompNew);
        });
    }

    public function updateUserSertifikasi(array $userSertifikasiNew)
    {
        DB::transaction(function () use ($userSertifikasiNew) {
            $userSertifikasi = new UserSertifikasiService();
            if (isset($userSertifikasiNew['id'])) {
                $userSertifikasi = $userSertifikasi->findById($userSertifikasiNew['id']);
            }
            $userSertifikasi->fill($userSertifikasiNew);
            $userSertifikasi->task_status = TaskStatus::PENDING;
            $userSertifikasi->customSaveWithUpload($userSertifikasiNew);
        });
    }

    public function updateUserUkom(array $userUkomNew, array $nilaiMansoskulNew, array $nilaiTeknisNew, $nip)
    {
        DB::transaction(function () use ($userUkomNew, $nilaiMansoskulNew, $nilaiTeknisNew, $nip) {

            $userUkom = new UserUkomService();
            $userUkom->fill($userUkomNew);
            $userUkom->nip = $nip;
            $userUkom->task_status = TaskStatus::APPROVE;
            $userUkom->customSaveWithUpload($userUkomNew, $nip);

            $nilaiMansoskul = new NilaiMansoskulService();
            $nilaiMansoskul->fill($nilaiMansoskulNew);
            $nilaiMansoskul->user_ukom_id = $userUkom->id;
            $nilaiMansoskul->customSave();

            $nilaiTeknis = new NilaiKompetensiTeknisService();
            $nilaiTeknis->fill($nilaiTeknisNew);
            $nilaiTeknis->user_ukom_id = $userUkom->id;
            $nilaiTeknis->customSave();
        });
    }
}
