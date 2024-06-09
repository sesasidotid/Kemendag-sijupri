<?php

namespace App\Http\Controllers\Siap;

use App\Enums\RoleCode;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\JabatanService;
use App\Http\Controllers\Maintenance\Service\JenjangService;
use App\Http\Controllers\Maintenance\Service\PangkatService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Security\Service\UserService;
use App\Http\Controllers\Siap\Service\UserJabatanService;
use App\Http\Controllers\Siap\Service\UserKompetensiService;
use App\Http\Controllers\Siap\Service\UserPakService;
use App\Http\Controllers\Siap\Service\UserPangkatService;
use App\Http\Controllers\Siap\Service\UserPendidikanService;
use App\Http\Controllers\Siap\Service\UserSertifikasiService;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public function index()
    {
        $userContext = auth()->user();
        $role = $userContext->role;

        if ($role->base == RoleCode::ADMIN_INSTANSI) {
            $user = $userContext;
            $unitKerjaList = new UnitKerjaService();
            $unitKerjaList  = $unitKerjaList->findByTipeInstansiCodeAndInstansiId($user->tipe_instansi_code, $user->instansi_id);
            return view('profile.instansi', compact('unitKerjaList', 'user'));
        } else if ($role->base == RoleCode::PENGATUR_SIAP) {
            $user = $userContext;
            return view('profile.unitkerja', compact('user'));
        } else if ($role->base == RoleCode::USER) {
            $userPendidikan = new UserPendidikanService();
            $userJabatan = new UserJabatanService();
            $userPangkat = new UserPangkatService();
            $userPak = new UserPakService();
            $userKompetensi = new UserKompetensiService();
            $userSertifikasi = new UserSertifikasiService();
            $jabatan = new JabatanService();
            $jenjang = new JenjangService();
            $pangkat = new PangkatService();

            $user = $userContext;
            $userDetail = $user->userDetail;
            $unitKerja = $user->unitKerja;
            $userPendidikanList = $userPendidikan->findByNip($userContext->nip);
            $userJabatanList = $userJabatan->findByNip($userContext->nip);
            $userPangkatList = $userPangkat->findByNip($userContext->nip);
            $userPakList = $userPak->findByNip($userContext->nip);
            $userKompetensiList = $userKompetensi->findByNip($userContext->nip);
            $userSertifikasiList = $userSertifikasi->findByNip($userContext->nip);
            $jabatanList = $jabatan->findAll();
            $jenjangList = $jenjang->findAll();
            $pangkatList = $pangkat->findAll();

            return view('siap.siap', compact(
                'user',
                'userDetail',
                'unitKerja',
                'userPendidikanList',
                'userJabatanList',
                'userPangkatList',
                'userPakList',
                'userKompetensiList',
                'userSertifikasiList',
                'jabatanList',
                'jenjangList',
                'pangkatList',
            ));
        }
    }

    public function detail()
    {
        $userContext = auth()->user();
        $role = $userContext->role;

        switch ($role->base) {
            case RoleCode::ADMIN_SIJUPRI:
                $user = $userContext;
                return view('profile.detailsijupri', compact('user'));
            case RoleCode::ADMIN_INSTANSI:
                $user = $userContext;
                $unitKerjaList = new UnitKerjaService();
                $unitKerjaList  = $unitKerjaList->findByTipeInstansiCodeAndInstansiId($user->tipe_instansi_code, $user->instansi_id);
                return view('profile.detailinstansi', compact('unitKerjaList', 'user'));
            case RoleCode::PENGATUR_SIAP:
                $user = $userContext;
                return view('profile.detailunitkerja', compact('user'));
            case RoleCode::USER:
                $user = $userContext;
                $userDetail = $user->userDetail;
                $userPendidikanList = $user->userPendidikan;
                $userJabatanList = $user->userJabatan;
                $userPangkatList = $user->userPangkat;
                $userPakList = $user->userPak;
                $userKompetensiList = $user->userKompetensi;
                $userSertifikasiList = $user->userSertifikasi;
                return view('profile.detail_jf', compact(
                    'user',
                    'userDetail',
                    'userPendidikanList',
                    'userJabatanList',
                    'userPangkatList',
                    'userPakList',
                    'userKompetensiList',
                    'userSertifikasiList',
                ));
        }
    }

    public function instansi_update(Request $request)
    {
        $request->validate([
            "unit_kerja_id" => 'required',
            "jenis_kelamin" => 'required',
            "no_hp" => 'required|min:10|max:15',
            "email" => 'required|email',
        ]);

        DB::transaction(function () use ($request) {
            $userContext = auth()->user();

            $profile = new ProfileService();
            $profile->updateUserDetailWithoutFile($request->all());

            $user = new UserService();
            $user = $user->findById($userContext->nip);
            $user->unit_kerja_id = $request['unit_kerja_id'];
            $user->customUpdate();
        });

        return redirect()->back();
    }

    public function unitkerjaOpd_update(Request $request)
    {
        $request->validate([
            "jenis_kelamin" => 'required',
            "no_hp" => 'required|min:10|max:15',
            "email" => 'required|email',
        ]);

        $profile = new ProfileService();
        $profile->updateUserDetailWithoutFile($request->all());

        return redirect()->back();
    }
    public function detailUser($nip)
    {
        $user = new UserService();
        $user = $user->findById($nip);
        $dataDiri = $user->userDetail;
        $opd = $user->unitKerja;
        $pendidikan = $user->userPendidikan;
        $kinerja = $user->userKinerja;

        $jabatan = $user->userJabatan;
        $pangkat = $user->userPangkat;
        $kompetensi = $user->userKompetensi;
        $sertifikasi = $user->userSertifikasi;
        $pak = $user->userPak;
        return view('opd.user.detail', compact('user', 'opd',  'dataDiri', 'pendidikan', 'jabatan', 'pangkat', 'kompetensi', 'sertifikasi', 'pak'));
    }
}
