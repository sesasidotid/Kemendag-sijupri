<?php

namespace App\Http\Controllers\Siap;

use App\Enums\RoleCode;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\JabatanService;
use App\Http\Controllers\Maintenance\Service\JenjangService;
use App\Http\Controllers\Maintenance\Service\PangkatService;
use App\Http\Controllers\Security\Service\UserService;
use App\Http\Controllers\Security\Service\RoleService;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserDetailService;
use App\Http\Controllers\Siap\Service\UserJabatanService;
use App\Http\Controllers\Siap\Service\UserKompetensiService;
use App\Http\Controllers\Siap\Service\UserPakService;
use App\Http\Controllers\Siap\Service\UserPangkatService;
use App\Http\Controllers\Siap\Service\UserPendidikanService;
use App\Http\Controllers\Siap\Service\UserSertifikasiService;
use App\Http\Controllers\Siap\Service\UserUkomService;
use App\Http\Controllers\Siap\Service\UserUkomServsice;
use Illuminate\Http\Request;

class SiapController extends Controller
{
    private $user;
    private $role;

    public function __construct(UserService $user, RoleService $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function external()
    {
        $userContext = auth()->user();

        switch ($userContext->role->base) {
            case RoleCode::ADMIN_SIJUPRI:
                $userList = $this->user->findByRoleCode(RoleCode::USER_EXTERNAL);
                return view('user.index_jf_sijupri', compact('userList'));
            case RoleCode::ADMIN_INSTANSI:
                $userList = $this->user->findByTipeInstansiCodeAndRoleCode($userContext->tipe_instansi_code, RoleCode::USER_EXTERNAL);
                return view('instansi.user.index', compact(
                    'userList'
                ));
            case RoleCode::PENGATUR_SIAP:
                $userList = $this->user->findByUnitKerjaIdAndRoleCode($userContext->unit_kerja_id, RoleCode::USER_EXTERNAL);
                return view('instansi.user.index', compact(
                    'userList'
                ));
        }
    }

    public function internal()
    {
        $userList = $this->user->findByRoleCode(RoleCode::USER_INTERNAL);
        return view('user.index_jf_sijupri', compact('userList'));
    }

    //List Admin
    public function admin_sijupri()
    {
        $userList = $this->user->findByRoleBase(RoleCode::ADMIN_SIJUPRI);
        return view('siap.adminSijupri.admin.siJupri', compact(
            'userList'
        ));
    }

    public function detail_admin_sijupri($nip)
    {

        $detailUser = $this->user->findByNip($nip);
        $roleData = $this->role->findByRoleBase(RoleCode::ADMIN_SIJUPRI);
        // dd($roleData);
        // die();
        return view('siap.adminSijupri.admin.detailSiJupri', compact(
            'detailUser',
            'roleData'
        ));
    }

    public function edit_admin_sijupri(Request $request)
    {

        $user = $this->user->findByNip($request->nip);
        $user->user_status = $request->user_status;
        $user->role_code = $request->role_code;
        $user->customupdate();
        return redirect()->back();
    }

    //List Admin
    public function admin_instansi(Request $request)
    {
        $userContext = auth()->user();
        $user = new UserService();
        $data = $request->all();

        switch ($userContext->role->base) {
            case RoleCode::ADMIN_SIJUPRI:
                $data['attr']['role']['base'] = RoleCode::ADMIN_INSTANSI;
                $data['attr']['delete_flag'] = false;
                $data['cond']['delete_flag'] = '=';
                $data['ordrs']['created_at'] = 'DESC';
                $userList = $user->findSearchPaginate($data);
                return view('user.index_instansi', compact(
                    'userList'
                ));
            case RoleCode::ADMIN_INSTANSI:
                $data['attr']['role']['base'] = RoleCode::ADMIN_INSTANSI;
                $data['attr']['instansi_id'] = $userContext->instansi_id;
                $data['attr']['delete_flag'] = false;
                $data['cond']['delete_flag'] = '=';
                $userList = $user->findSearchPaginate($data);
                return view('user.index_instansi_2', compact(
                    'userList'
                ));
        }
    }

    //List Admin
    public function admin_pengelola(Request $request)
    {
        $userContext = auth()->user();
        $user = new UserService();
        $data = $request->all();

        if ($userContext->role->base == RoleCode::ADMIN_SIJUPRI) {
            $data['attr']['role']['base'] = RoleCode::PENGATUR_SIAP;
            $data['attr']['delete_flag'] = false;
            $data['cond']['delete_flag'] = '=';
            $data['ordrs']['created_at'] = 'DESC';
            $userList = $user->findSearchPaginate($data);
            return view('user.index_unit_kerja', compact(
                'userList'
            ));
        } else if ($userContext->role->base == RoleCode::ADMIN_INSTANSI) {
            $data['attr']['role'] = ["base" => RoleCode::PENGATUR_SIAP];
            $data['attr']['tipe_instansi_code'] = $userContext->tipe_instansi_code;
            $data['attr']['delete_flag'] = false;
            $data['cond']['delete_flag'] = '=';
            $userList = $user->findSearchPaginate($data);
            return view('instansi.opd.admin', compact(
                'userList'
            ));
        }
    }

    public function detail_external($nip)
    {
        $user = new UserService();
        $role = new RoleService();

        $detailUser = $user->findByNip($nip);
        return view('siap.adminSijupri.user.detail', compact(
            'detailUser'
        ));
    }

    public function detail_admin_instansi(Request $request)
    {
        $user = new UserService();
        $role = new RoleService();

        $user = $user->findByNip($request->nip);
        return view('user.detail_instansi_sijupri', compact(
            'user'
        ));
    }

    public function detail_admin_pengelola($nip)
    {
        $user = new UserService();
        $role = new RoleService();

        $detailUser = $user->findByNip($nip);
        $roleData = $role->findByRoleBase(RoleCode::PENGATUR_SIAP);

        return view('user.detail_unit_kerja', compact(
            'detailUser',
            'roleData'
        ));
    }

    public function verifyUserDetail(Request $request)
    {
        $userDetail = new UserDetailService();
        $userDetail->task_status = $request->status;
        $userDetail->comment = $request->comment;
        $userDetail->customUpdate();
    }

    public function verifyUserPendidikan(Request $request)
    {
        $userPendidikan = new UserPendidikanService();
        $userPendidikan->task_status = $request->status;
        $userPendidikan->comment = $request->comment;
        $userPendidikan->customUpdate();
    }

    public function verifyUserJabatan(Request $request)
    {
        $userJabatan = new UserJabatanService();
        $userJabatan->task_status = $request->status;
        $userJabatan->comment = $request->comment;
        $userJabatan->customUpdate();
    }

    public function verifyUserPangkat(Request $request)
    {
        $userPangkat = new UserPangkatService();
        $userPangkat->task_status = $request->status;
        $userPangkat->comment = $request->comment;
        $userPangkat->customUpdate();
    }

    public function verifyUserKinerja(Request $request)
    {
        $userPak = new UserPakService();
        $userPak->task_status = $request->status;
        $userPak->comment = $request->comment;
        $userPak->customUpdate();
    }

    public function verifyUserKompetensi(Request $request)
    {
        $userKompetensi = new UserKompetensiService();
        $userKompetensi->task_status = $request->status;
        $userKompetensi->comment = $request->comment;
        $userKompetensi->customUpdate();
    }

    public function verifyUserUkom(Request $request)
    {
        $userUkom = new UserUkomService();
        $userUkom->task_status = $request->status;
        $userUkom->comment = $request->comment;
        $userUkom->customUpdate();
    }

    public function verifyUserSertifikasi(Request $request)
    {
        $userSertifikasi = new UserSertifikasiService();
        $userSertifikasi->task_status = $request->status;
        $userSertifikasi->comment = $request->comment;
        $userSertifikasi->customUpdate();
    }

    //profile:
    public function userDetailStore(Request $request)
    {
        $profile = new ProfileService();
        $userDetail = new UserDetailService();
        $validation = [
            "nik" => 'required',
            "jenis_kelamin" => 'required',
            "no_hp" => 'required|min:10|max:15',
            "email" => 'required|email',
            "tempat_lahir" => 'required',
            "tanggal_lahir" => 'required',
        ];
        $userDetail = $userDetail->findByNip(auth()->user()->nip);
        if (!$userDetail || !$userDetail->file_ktp) {
            $validation['file_ktp'] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);


        $profile->updateUserDetail($request->all());
        return redirect()->back();
    }

    public function userPendidikanDetail(Request $request)
    {
        $userPendidikan = new UserPendidikanService();
        $userPendidikan = $userPendidikan->findById($request->id);

        return view('siap.siap_pendidikan_update', compact(
            'userPendidikan'
        ));
    }

    public function userPendidikanStore(Request $request)
    {
        $profile = new ProfileService();
        $validation = [
            "level" => 'required',
            "instansi_pendidikan" => 'required',
            "jurusan" => 'required',
            "bulan_kelulusan" => 'required',
        ];
        if (!isset($request->id)) {
            $validation['file_ijazah'] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);

        $profile->updateUserPendidikan($request->all());
        return redirect()->route('/profile');
    }

    public function userPendidikanDelete(Request $request)
    {
        $userPendidikan = new UserPendidikanService();
        $userPendidikan = $userPendidikan->findById($request->id);
        $userPendidikan->customDelete();
        return redirect()->back();
    }

    public function userJabatanDetail(Request $request)
    {
        $userJabatan = new UserJabatanService();
        $jabatan = new JabatanService();
        $jenjang = new JenjangService();

        $userJabatan = $userJabatan->findById($request->id);
        $jabatanList = $jabatan->findAll();
        $jenjangList = $jenjang->findAll();

        return view('siap.siap_jabatan_update', compact(
            'userJabatan',
            'jabatanList',
            'jenjangList'
        ));
    }

    public function userJabatanStore(Request $request)
    {
        $profile = new ProfileService();
        $jabatan = new JabatanService();

        $validation = [
            "jabatan_code" => "required",
            "jenjang_code" => "required",
            "tmt" => 'required',
        ];
        if (!isset($request->id)) {
            $validation['file_sk_jabatan'] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);

        $request['name'] = $jabatan->findById($request['jabatan_code'])->name;
        $profile->updateUserJabatan($request->all());
        return redirect()->route('/profile');
    }

    public function userJabatanDelete(Request $request)
    {
        $userJabatan = new UserJabatanService();
        $userJabatan = $userJabatan->findById($request->id);
        $userJabatan->customDelete();
        return redirect()->back();
    }

    public function userPangkatDetail(Request $request)
    {
        $userPangkat = new UserPangkatService();
        $pangkat = new PangkatService();

        $userPangkat = $userPangkat->findById($request->id);
        $pangkatList = $pangkat->findAll();

        return view('siap.siap_pangkat_update', compact(
            'userPangkat',
            'pangkatList',
        ));
    }

    public function userPangkatStore(Request $request)
    {
        $profile = new ProfileService();

        $validation = [
            "tmt" => 'required',
            "pangkat_id" => 'required',
        ];
        if (!isset($request->id)) {
            $validation['file_sk_pangkat'] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);

        $profile->updateUserPangkat($request->all());
        return redirect()->route('/profile');
    }

    public function userPangkatDelete(Request $request)
    {
        $userPangkat = new UserPangkatService();
        $userPangkat = $userPangkat->findById($request->id);
        $userPangkat->customDelete();
        return redirect()->back();
    }

    public function userPakDetail(Request $request)
    {
        $userPak = new UserPakService();
        $userPak = $userPak->findById($request->id);

        return view('siap.siap_kinerja_update', compact(
            'userPak'
        ));
    }

    public function userKinerjaStore(Request $request)
    {
        $profile = new ProfileService();

        $validation = [
            "periode" => 'required',
            "tgl_mulai" => 'required',
            "tgl_selesai" => 'required',
            "nilai_kinerja" => 'required',
            "nilai_perilaku" => 'required',
            "predikat" => 'required',
        ];
        if (!isset($request->id)) {
            $validation['file_doc_ak'] = 'required|mimes:pdf|max:2048';
            $validation['file_hasil_eval'] = 'required|mimes:pdf|max:2048';
            $validation['file_akumulasi_ak'] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);

        $profile->updateUserPak($request->all());
        return redirect()->route('/profile');
    }

    public function userPakDelete(Request $request)
    {
        $userPak = new UserPakService();
        $userPak = $userPak->findById($request->id);
        $userPak->customDelete();
        return redirect()->back();
    }

    public function userKompetensiDetail(Request $request)
    {
        $userKompetensi = new UserKompetensiService();
        $userKompetensi = $userKompetensi->findById($request->id);

        return view('siap.siap_kompetensi_update', compact(
            'userKompetensi'
        ));
    }

    public function userKompetensiStore(Request $request)
    {
        $profile = new ProfileService();

        $validation = [
            "name" => 'required',
            "kategori" => 'required',
            "tgl_mulai" => 'required',
            "tgl_selesai" => 'required',
            "tgl_sertifikat" => 'required',
        ];
        if (!isset($request->id)) {
            $validation['file_sertifikat'] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);

        $profile->updateUserKompetensi($request->all());
        return redirect()->route('/profile');
    }

    public function userKompetensiDelete(Request $request)
    {
        $userKompetensi = new UserKompetensiService();
        $userKompetensi = $userKompetensi->findById($request->id);
        $userKompetensi->customDelete();
        return redirect()->back();
    }

    public function userSertifikasiDetail(Request $request)
    {
        $userSertifikasi = new UserSertifikasiService();
        $userSertifikasi = $userSertifikasi->findById($request->id);

        return view('siap.siap_sertifikasi_update', compact(
            'userSertifikasi'
        ));
    }

    public function userSertifikasiStore(Request $request)
    {
        $profile = new ProfileService();

        $validation = [
            "kategori" => 'required',
            "nomor_sk" => 'required',
            "tanggal_sk" => 'required',
        ];
        if ($request['kategori'] !== "Pegawai Berhak") {
            $validation['wilayah_kerja'] = 'required';
            $validation['berlaku_mulai'] = 'required';
            $validation['berlaku_sampai'] = 'required';
            $validation['uu_kawalan'] = 'required';
        }
        if (!isset($request->id)) {
            $validation['file_doc_sk'] = 'required|mimes:pdf|max:2048';
            if ($request['kategori'] !== "Pegawai Berhak") {
                $validation['file_ktp_ppns'] = 'required|mimes:pdf|max:2048';
            }
        }
        $request->validate($validation);

        $profile->updateUserSertifikasi($request->all());
        return redirect()->route('/profile');
    }

    public function userSertifikasiDelete(Request $request)
    {
        $userSertifikasi = new UserSertifikasiService();
        $userSertifikasi = $userSertifikasi->findById($request->id);
        $userSertifikasi->customDelete();
        return redirect()->back();
    }
}
