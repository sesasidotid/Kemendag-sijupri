<?php

namespace App\Http\Controllers\Siap\Service;

use App\Enums\TipeInstansi;
use App\Enums\UserStatus;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Maintenance\Service\KabKotaService;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use App\Http\Controllers\Security\Service\UserService;
use App\Models\Siap\UnitKerja;
use Illuminate\Support\Facades\DB;

class RegistrationService
{

    public function register($request)
    {
        DB::transaction(function () use ($request) {
            $user = new UserService();

            $user = $user->findById($request['nip']);
            if ($user && !$user->delete_flag) {
                throw new BusinessException([
                    "message" => "Nip Sudah Ada",
                    "error code" => "UKOM-00001",
                    "code" => 500
                ], 500);
            }

            if (isset($request['instansi_initials']) && $request['instansi_initials'] != null) {
                $request['instansi_id'] = $this->getCreateInstansi($request);
            }

            if ($user) {
                $user->unit_kerja_id = null;
                $user->fill($request);
                $user->user_status = UserStatus::ACTIVE;
                $user->delete_flag = false;
                $user->instansi_id = $request['instansi_id'];
                $user->customUpdate();
            } else {
                $user = new UserService();
                $user->fill($request);
                $user->user_status = UserStatus::ACTIVE;
                $user->delete_flag = false;
                $user->instansi_id = $request['instansi_id'];
                $user->customSave();
            }
        });
    }

    private function getCreateInstansi(array $request)
    {
        $instansiName = null;
        if ($request['tipe_instansi_code'] == TipeInstansi::PROVINSI) {
            $provinsi = new ProvinsiService();
            $provinsi = $provinsi->findById($request['provinsi_id']);
            if ($request['instansi_initials'] == 1) {
                $instansiName = "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Provinsi " . str_replace("Provinsi", "", ucwords(strtolower($provinsi->name)));
            } else if ($request['instansi_initials'] == 2) {
                $instansiName = "Badan Kepegawaian Daerah Provinsi " . str_replace("Provinsi", "", ucwords(strtolower($provinsi->name)));
            }
        } else if ($request['tipe_instansi_code'] == TipeInstansi::KABUPATEN) {
            $kabupaten = new KabKotaService();
            $kabupaten = $kabupaten->findById($request['kabupaten_id']);
            if ($request['instansi_initials'] == 1) {
                $instansiName = "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kabupaten " . str_replace("Kabupaten", "", ucwords(strtolower($kabupaten->name)));
            } else if ($request['instansi_initials'] == 2) {
                $instansiName = "Badan Kepegawaian Daerah Kabupaten " . str_replace("Kabupaten", "", ucwords(strtolower($kabupaten->name)));
            }
        } else if ($request['tipe_instansi_code'] == TipeInstansi::KOTA) {
            $kota = new KabKotaService();
            $kota = $kota->findById($request['kota_id']);
            if ($request['instansi_initials'] == 1) {
                $instansiName = "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota " . str_replace("Kota", "", ucwords(strtolower($kota->name)));
            } else if ($request['instansi_initials'] == 2) {
                $instansiName = "Badan Kepegawaian Daerah Kota " . str_replace("Kota", "", ucwords(strtolower($kota->name)));
            }
        }
        $instansi = new InstansiService();
        $instansiOld = $instansi->findByName($instansiName);

        if ($instansiOld) {
            return $instansiOld->id;
        } else {
            $instansi->name = $instansiName;
            $instansi->provinsi_id = $request['provinsi_id'] ?? null;
            $instansi->kabupaten_id = $request['kabupaten_id'] ?? null;
            $instansi->kota_id = $request['kota_id'] ?? null;
            $instansi->description = $instansiName;
            $instansi->tipe_instansi_code = $request['tipe_instansi_code'];
            $instansi->customSave();

            return $instansi->id;
        }
    }

    private function getUnitKerja(array $request): UnitKerja
    {
        $unitKerja = new UnitKerjaService();
        $instansi = new InstansiService();

        $instansi = $instansi->findById($request['instansi_id']);
        $unitKerjaNew = null;
        if ($request['tipe_instansi_code'] == TipeInstansi::PROVINSI) {
            $provinsi = new ProvinsiService();
            $provinsi = $provinsi->findById($request['provinsi_id']);

            $unitKerjaNew = [
                'provinsi_id' => $request['provinsi_id'],
                'name' => $instansi->name . ' ' . $provinsi->name,
                'operasional' => 'DINAS',
            ];
        } else if ($request['tipe_instansi_code'] == TipeInstansi::KABUPATEN) {
            $kabupaten = new KabKotaService();
            $kabupaten = $kabupaten->findById($request['kabupaten_id']);

            $unitKerjaNew = [
                'provinsi_id' => $request['provinsi_id'],
                'kabupaten_id' => $request['kabupaten_id'],
                'name' => str_replace("Kabupaten", "", $instansi->name) . ' ' . $kabupaten->name,
                'operasional' => 'DINAS',
            ];
        } else if ($request['tipe_instansi_code'] == TipeInstansi::KOTA) {
            $kota = new KabKotaService();
            $kota = $kota->findById($request['kota_id']);

            $unitKerjaNew = [
                'provinsi_id' => $request['provinsi_id'],
                'kota_id' => $request['kota_id'],
                'name' => str_replace("Kota", "", $instansi->name) . ' ' . $kota->name,
                'operasional' => 'DINAS',
            ];
        }

        $unitKerja->tipe_instansi_code = $request['tipe_instansi_code'];
        $unitKerjaList = $unitKerja->findWith($unitKerjaNew);
        if (empty($unitKerjaList))
            return $unitKerjaList[0];
        else {
            $unitKerja->fill($unitKerjaNew);
            return $unitKerja->customSave();
        }
    }
}
