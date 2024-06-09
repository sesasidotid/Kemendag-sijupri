<?php

namespace App\Http\Controllers\Security;

use App\Enums\RoleCode;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Security\Service\UserService;
use App\Http\Controllers\Siap\Service\UserDetailService;
use App\Http\Controllers\Siap\Service\UserJabatanService;
use App\Http\Controllers\Siap\Service\UserKompetensiService;
use App\Http\Controllers\Siap\Service\UserPakService;
use App\Http\Controllers\Siap\Service\UserPangkatService;
use App\Http\Controllers\Siap\Service\UserPendidikanService;
use App\Http\Controllers\Siap\Service\UserSertifikasiService;
use Illuminate\Http\Request;
use App\Enums\UserStatus;
use App\Http\Controllers\Security\Service\RoleService;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function userJF(Request $request)
    {
        $userContext = auth()->user();
        $user = new UserService();
        $data = $request->all();
        $data['attr']['role']['base'] = RoleCode::USER;
        $data['attr']['delete_flag'] = false;
        $data['cond']['delete_flag'] = '=';
        $data['cond']['user_status'] = '=';
        $data['ordrs']['created_at'] = 'DESC';

        switch ($userContext->role->base) {
            case RoleCode::ADMIN_SIJUPRI:
                $userList = $user->findSearchPaginate($data);
                return view('user.index_jf_sijupri', compact('userList'));
            case RoleCode::ADMIN_INSTANSI:
                $data['tipe_instansi_code'] = $userContext->tipe_instansi_code;
                $userList = $user->findSearchPaginate($data);
                return view('instansi.user.index', compact(
                    'userList'
                ));
            case RoleCode::PENGATUR_SIAP:
                $data['attr']['unit_kerja_id'] = $userContext->unit_kerja_id;
                $userList = $user->findSearchPaginate($data);
                return view('instansi.user.index', compact(
                    'userList'
                ));
        }
    }

    public function userJfDetail(Request $request)
    {
        $userContext = auth()->user();
        $user = new UserService();
        $user = $user->findById($request->nip);

        switch ($userContext->role->base) {
            case RoleCode::ADMIN_SIJUPRI:
                $userDetail = $user->userDetail ?? null;
                $userPendidikanList = $user->userPendidikan ?? null;
                $userJabatanList = $user->userJabatan ?? null;
                $userPangkatList = $user->userPangkat ?? null;
                $userPakList = $user->userPak ?? null;
                $userKompetensiList = $user->userKompetensi ?? null;
                $userSertifikasiList = $user->userSertifikasi ?? null;

                return view('user.detail_jf_sijupri', compact(
                    'user',
                    'userDetail',
                    'userPendidikanList',
                    'userJabatanList',
                    'userPangkatList',
                    'userPakList',
                    'userKompetensiList',
                    'userSertifikasiList',
                ));
            case RoleCode::ADMIN_INSTANSI:
                $userDetail = $user->userDetail;
                $userPendidikanList = $user->userPendidikan;
                $userJabatanList = $user->userJabatan;
                $userPangkatList = $user->userPangkat;
                $userPakList = $user->userPak;
                $userKompetensiList = $user->userKompetensi;
                $userSertifikasiList = $user->userSertifikasi;
                return;
            case RoleCode::PENGATUR_SIAP:
                $userDetail = new UserDetailService();
                $userPendidikan = new UserPendidikanService();
                $userJabatan = new UserJabatanService();
                $userPangkat = new UserPangkatService();
                $userPak = new UserPakService();
                $userKompetensi = new UserKompetensiService();
                $userSertifikasi = new UserSertifikasiService();

                $userDetail = $userDetail->findByNip($user->nip);
                $userPendidikanList = $userPendidikan->findByNipAndNotReject($user->nip);
                $userJabatanList = $userJabatan->findByNipAndNotReject($user->nip);
                $userPangkatList = $userPangkat->findByNipAndNotReject($user->nip);
                $userPakList = $userPak->findByNipAndNotReject($user->nip);
                $userKompetensiList = $userKompetensi->findByNipAndNotReject($user->nip);
                $userSertifikasiList = $userSertifikasi->findByNipAndNotReject($user->nip);
                return view('user.detail_jf_opd', compact(
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

    public function indexAdminSijupri(Request $request)
    {
        $user = new UserService();
        $data = $request->all();

        $data['attr']['role']['base'] = RoleCode::ADMIN_SIJUPRI;
        $data['attr']['delete_flag'] = false;
        $data['cond']['delete_flag'] = '=';
        $data['ordrs']['created_at'] = 'DESC';
        $userList = $user->findSearchPaginate($data);
        return view('user.index_sijupri', compact(
            'userList'
        ));
    }

    public function detailAdminSijupri($nip)
    {
        $user = new UserService();
        $role = new RoleService();

        $detailUser = $user->findByNip($nip);
        $roleData = $role->findByRoleBase(RoleCode::ADMIN_SIJUPRI);

        return view('user.detail_sijupri', compact(
            'detailUser',
            'roleData'
        ));
    }

    public function editAdminSijupri(Request $request)
    {
        $request->validate([
            'user_status' => 'required',
            'role_code' => 'required',
        ]);

        $user = new UserService();

        $access_method = [
            'read' => true,
            'create' => $request->filled('access_method.create'),
            'update' => $request->filled('access_method.update'),
            'delete' => $request->filled('access_method.delete'),
        ];

        $user = $user->findByNip($request->nip);
        $user->user_status = $request->user_status;
        $user->role_code = $request->role_code;
        $user->access_method = ((object) $access_method);
        if ($request->user_status == UserStatus::DELETED) $user->delete_flag = true;
        else $user->delete_flag = false;

        $user->customupdate();
        return redirect()->back();
    }

    public function editJf(Request $request)
    {
        $request->validate(['user_status' => 'required']);
        $user = new UserService();

        $user = $user->findByNip($request->nip);
        if (isset($request->delete_flag)) {
            $user->delete_flag = true;
            $user->user_status = UserStatus::DELETED;

            $user->customDelete();
            return redirect()->route('/user/user_jf');
        } else {
            $user->delete_flag = false;
            $user->user_status = $request->user_status;

            $user->customupdate();
            return redirect()->back();
        }
    }

    public function editInstansi(Request $request)
    {
        $request->validate(['user_status' => 'required']);

        $user = new UserService();

        $user = $user->findByNip($request->nip);
        if (isset($request->delete_flag)) {
            $user->delete_flag = true;
            $request->user_status == UserStatus::DELETED;

            $user->customDelete();
            return redirect()->route('/user/admin_instansi');
        } else {
            $user->delete_flag = false;
            $user->user_status = $request->user_status;

            $user->customupdate();
            return redirect()->back();
        }
    }

    public function editOpd(Request $request)
    {
        $request->validate(['user_status' => 'required']);

        $user = new UserService();

        $user = $user->findByNip($request->nip);
        if (isset($request->delete_flag)) {
            $user->delete_flag = true;
            $request->user_status == UserStatus::DELETED;

            $user->customDelete();
            return redirect()->route('/user/admin_unit_kerja_instansi_daerah');
        } else {
            $user->delete_flag = false;
            $user->user_status = $request->user_status;

            $user->customupdate();
            return redirect()->back();
        }
    }

    public function indexAdminInstansi()
    {
    }

    public function indexAdminUnitKerjaOPD()
    {
    }

    public function indexUserJF()
    {
    }

    public function verifikasi()
    {
        $userContext = auth()->user();

        $user = new UserService();
        if (auth()->user()->role_code == 'opd') {
            $userList = $user->findByUnitKerjaIdAndRoleCode($userContext->unitKerja->id, RoleCode::USER_EXTERNAL);
            return view('verifikasi.opd.user', compact('userList'));
        } elseif (auth()->user()->role_code == 'admin_pak') {
            $userList = $user->findByRoleCode(RoleCode::USER_EXTERNAL);
            return view('verifikasi.opd.user_pak', compact('userList'));
        }
    }

    public function aktivasi(Request $request, $nip)
    {
        $user = new UserService();
        try {
            $user = $user->findById($nip);
            if ($request->aktivasi == "ACTIVE") {
                $user->user_status = UserStatus::ACTIVE;
                $user->customUpdate();
                return redirect('siap/verifikasi/user');
            } elseif ($request->aktivasi == "NOT_ACTIVE") {
                $user->user_status = UserStatus::NOT_ACTIVE;
                $user->customUpdate();
                return redirect('siap/verifikasi/user');
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function verifikasiUserDetail(Request $request)
    {
        if ($request->task_status == TaskStatus::REJECT) {
            $request->validate([
                'task_status' => 'required',
                'comment' => 'required'
            ]);
        } else $request->validate(['task_status' => 'required']);

        DB::transaction(function () use ($request) {
            $userDetail = new UserDetailService();
            $userDetail = $userDetail->findById($request->id);

            $userDetail->task_status = $request->task_status;
            $userDetail->comment = $request->comment ?? null;
            $userDetail->customUpdate();
        });

        return redirect()->back();
    }

    public function verifikasiUserPendidikan(Request $request)
    {
        if ($request->task_status == TaskStatus::REJECT) {
            $request->validate([
                'task_status' => 'required',
                'comment' => 'required'
            ]);
        } else $request->validate(['task_status' => 'required']);

        DB::transaction(function () use ($request) {
            $userPendidikan = new UserPendidikanService();
            $userDetail = new UserDetailService();
            $userPendidikan = $userPendidikan->findById($request->id);

            $userPendidikan->task_status = $request->task_status;
            $userPendidikan->comment = $request->comment ?? null;
            $userPendidikan->customUpdate();

            $nip = $userPendidikan->nip;
            $userPendidikan = $userPendidikan->findLatestByNip($nip);

            $userDetail = $userDetail->findByNip($nip);
            $userDetail->user_pendidikan_id = $userPendidikan->id ?? null;
            $userDetail->customUpdate();
        });

        return redirect()->back();
    }

    public function verifikasiUserJabatan(Request $request)
    {
        if ($request->task_status == TaskStatus::REJECT) {
            $request->validate([
                'task_status' => 'required',
                'comment' => 'required'
            ]);
        } else $request->validate(['task_status' => 'required']);

        DB::transaction(function () use ($request) {
            $userJabatan = new UserJabatanService();
            $userDetail = new UserDetailService();
            $userJabatan = $userJabatan->findById($request->id);

            $userJabatan->task_status = $request->task_status;
            $userJabatan->comment = $request->comment ?? null;
            $userJabatan->customUpdate();

            $nip = $userJabatan->nip;
            $userJabatan = $userJabatan->findLatestByNip($nip);

            $userDetail = $userDetail->findByNip($nip);
            $userDetail->user_jabatan_id = $userJabatan->id ?? null;
            $userDetail->customUpdate();
        });

        return redirect()->back();
    }

    public function verifikasiUserPangkat(Request $request)
    {
        if ($request->task_status == TaskStatus::REJECT) {
            $request->validate([
                'task_status' => 'required',
                'comment' => 'required'
            ]);
        } else $request->validate(['task_status' => 'required']);

        DB::transaction(function () use ($request) {
            $userPangkat = new UserPangkatService();
            $userDetail = new UserDetailService();
            $userPangkat = $userPangkat->findById($request->id);

            $userPangkat->task_status = $request->task_status;
            $userPangkat->comment = $request->comment ?? null;
            $userPangkat->customUpdate();

            $nip = $userPangkat->nip;
            $userPangkat = $userPangkat->findLatestByNip($nip);

            $userDetail = $userDetail->findByNip($nip);
            $userDetail->user_pangkat_id = $userPangkat->id ?? null;
            $userDetail->customUpdate();
        });

        return redirect()->back();
    }

    public function verifikasiUserKompetensi(Request $request)
    {
        if ($request->task_status == TaskStatus::REJECT) {
            $request->validate([
                'task_status' => 'required',
                'comment' => 'required'
            ]);
        } else $request->validate(['task_status' => 'required']);

        $userKompetensi = new UserKompetensiService();
        $userKompetensi = $userKompetensi->findById($request->id);

        $userKompetensi->task_status = $request->task_status;
        $userKompetensi->comment = $request->comment ?? null;
        $userKompetensi->customUpdate();

        return redirect()->back();
    }

    public function verifikasiUserSertifikasi(Request $request)
    {
        if ($request->task_status == TaskStatus::REJECT) {
            $request->validate([
                'task_status' => 'required',
                'comment' => 'required'
            ]);
        } else $request->validate(['task_status' => 'required']);

        $userSertifikasi = new UserSertifikasiService();
        $userSertifikasi = $userSertifikasi->findById($request->id);

        $userSertifikasi->task_status = $request->task_status;
        $userSertifikasi->comment = $request->comment ?? null;
        $userSertifikasi->customUpdate();

        return redirect()->back();
    }

    public function kinerja_create(Request $request)
    {
        if ($request->task_status == TaskStatus::REJECT) {
            $request->validate([
                'task_status' => 'required',
                'comment' => 'required'
            ]);
        } else $request->validate(['task_status' => 'required']);

        DB::transaction(function () use ($request) {
            $userPak = new UserPakService();
            $userDetail = new UserDetailService();
            $userPak = $userPak->findById($request->id);

            $userPak->task_status = $request->task_status;
            $userPak->comment = $request->comment ?? null;
            $userPak->customUpdate();

            $nip = $userPak->nip;
            $userPak = $userPak->findLatestByNip($nip);

            $userDetail = $userDetail->findByNip($nip);
            $userDetail->user_pak_id = $userPak->id ?? null;
            $userDetail->customUpdate();
        });

        return redirect()->back();
    }

    public function access()
    {
    }

    public function editAccess()
    {
    }
}
