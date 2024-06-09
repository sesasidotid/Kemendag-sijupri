<?php

namespace App\Http\Controllers\Ukom;

use App\Enums\TaskStatus;
use App\Enums\UkomStatus;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\JabatanService;
use App\Http\Controllers\Maintenance\Service\StorageService;
use App\Http\Controllers\Ukom\Service\UkomService;
use App\Http\Controllers\Maintenance\Service\JenjangService;
use App\Http\Controllers\Maintenance\Service\KabKotaService;
use App\Http\Controllers\Maintenance\Service\PangkatService;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use App\Http\Controllers\Security\Service\UserService;
use App\Http\Controllers\Siap\Service\InstansiService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use App\Http\Controllers\Siap\Service\UserKompetensiService;
use App\Http\Controllers\Siap\Service\UserPakService;
use App\Http\Controllers\Siap\Service\UserPendidikanService;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use App\Http\Controllers\Ukom\Service\UkomPeriodeService;
use App\Imports\UkomMansoskulImport;
use App\Imports\UkomTeknisImport;
use App\Models\Audit\AuditTimeline;
use App\Models\Maintenance\Pangkat;
use App\Models\Maintenance\SystemConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UkomController extends Controller
{

    public function pendaftaranUkom()
    {
        $userContext = auth()->user();

        $ukom = new UkomService();
        $ukom = $ukom->findByNipAndStatusNot($userContext->nip, UkomStatus::SELESAI);
        return view('ukom.pendaftaran_ukom', compact(
            'ukom'
        ));
    }

    public function kenaikanJenjang()
    {
        $userContext = auth()->user();
        $ukomPeriode = new UkomPeriodeService();
        $nextJenjang = new JenjangService();
        $nextJenjang = $nextJenjang->findNextJenjang($userContext->jabatan->jenjang->urutan);

        $systemConfiguration = SystemConfiguration::find("file_persyaratan_ukom");
        $filePersyaratan = $systemConfiguration->property[str_replace('user_', '', $userContext->role_code)]['kenaikan_jenjang'];
        $user = $userContext;
        $ukomPeriode = $ukomPeriode->findAll()[0] ?? null;

        return view('ukom.kenaikan_jenjang', compact(
            'user',
            'nextJenjang',
            'ukomPeriode',
            'filePersyaratan'
        ));
    }

    public function kenaikanJenjangStore(Request $request)
    {
        $validation = [
            'ukom_periode_id' => 'required',
            'type' => 'required',
        ];
        $userContext = auth()->user();

        $ukom = new UkomService();
        $nextJenjang = new JenjangService();

        if ($ukom->findByNipAndStatusNot($userContext->nip, UkomStatus::SELESAI)) {
            throw new BusinessException([
                "message" => "Masih Ada Pendaftaran Ukom yang masih Aktif",
                "error code" => "UKOM-00001",
                "code" => 500
            ], 500);
        }

        $systemConfiguration = SystemConfiguration::find("file_persyaratan_ukom");
        $filePersyaratan = $systemConfiguration->property[str_replace('user_', '', $userContext->role_code)]['kenaikan_jenjang'];
        foreach ($filePersyaratan['values'] as $key => $value) {
            $validation[str_replace(' ', '_', strtolower($value))] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);
        $nextJenjang = $nextJenjang->findNextJenjang($userContext->jabatan->jenjang->urutan);

        DB::transaction(function () use ($request, $userContext, $ukom, $nextJenjang, $filePersyaratan) {
            $ukom->fill($request->all());
            $ukom->nip = $userContext->nip;
            $ukom->email = $userContext->userDetail->email;
            $ukom->angka_kredit = $userContext->pak->angka_kredit;
            $ukom->name = $userContext->name;
            $ukom->jenis = "kenaikan_jenjang";
            $ukom->status = UkomStatus::PENDAFTARAN;
            $ukom->task_status = TaskStatus::PENDING;
            $ukom->jabatan_code = $userContext->jabatan->jabatan_code;
            $ukom->jenjang_code = $userContext->jabatan->jenjang_code;
            $ukom->pangkat_id = $userContext->pangkat->pangkat_id;
            $ukom->tujuan_jenjang_code = $nextJenjang->code;
            $ukom->tujuan_jabatan_code = $ukom->jabatan_code;
            $ukom->tujuan_pangkat_id = $ukom->pangkat_id + 1;
            $ukom->instansi_id = $userContext->instansi_id;
            $ukom->unit_kerja_id = $userContext->unit_kerja_id;
            $ukom->detail = ([
                'karpeg' => $userContext->userDetail->karpeg,
                'tmt_jabatan' => $userContext->jabatan->tmt,
                'tmt_pangkat' => $userContext->pangkat->tmt,
                'tempat_lahir' => $userContext->userDetail->tempat_lahir,
                'tanggal_lahir' => $userContext->userDetail->tanggal_lahir,
                'jenis_kelamin' => $userContext->userDetail->jenis_kelamin,
                'jabatan_name' => $userContext->jabatan->jabatan->name,
                'jenjang_name' => $userContext->jabatan->jenjang->name,
                'pangkat_name' => $userContext->pangkat->pangkat->name,
                'tujuan_jabatan_name' => $userContext->jabatan->jabatan->name,
                'tujuan_jenjang_name' => $nextJenjang->name,
                'tujuan_pangkat_name' => Pangkat::where('id', $ukom->pangkat_id + 1)->first()->name ?? "",
                'instansi_name' => $userContext->instansi->name,
                'unit_kerja_name' => $userContext->unitKerja->name,
                'provinsi_name' => $userContext->instansi->provinsi->name ?? null,
                'kabupaten_name' => $userContext->instansi->kabupaten->name ?? null,
                'kota_kota' => $userContext->instansi->kota->name ?? null,
                'unit_kerja_alamat' => $userContext->unitKerja->alamat,
                'pendidikan' => $userContext->pendidikan->level,
                'jurusan' => $userContext->pendidikan->jurusan,
            ]);
            $ukom->customSaveWithUpload($request->all(), $filePersyaratan['values']);

            AuditTimeline::create([
                'association' => 'tbl_ukom',
                'association_key' => $ukom->id,
                'description' => 'Menunggu Hasil Pendaftaran'
            ]);
        });

        return redirect()->route('/ukom/pendaftaran_ukom');
    }

    public function perpindahanJabatan()
    {
        $userContext = auth()->user();
        $ukomPeriode = new UkomPeriodeService();
        $jabatan = new JabatanService();

        $systemConfiguration = SystemConfiguration::find("file_persyaratan_ukom");
        $filePersyaratan = $systemConfiguration->property[str_replace('user_', '', $userContext->role_code)]['perpindahan'];
        $user = $userContext;
        $ukomPeriode = $ukomPeriode->findAll()[0] ?? null;
        $jabatanList = $jabatan->findAll();

        return view('ukom.perpindahan', compact(
            'user',
            'jabatanList',
            'ukomPeriode',
            'filePersyaratan'
        ));
    }

    public function perpindahanJabatanStore(Request $request)
    {
        $validation = [
            'ukom_periode_id' => 'required',
            'type' => 'required',
            'tujuan_jabatan_code' => 'required',
        ];
        $userContext = auth()->user();

        $ukom = new UkomService();

        if ($ukom->findByNipAndStatusNot($userContext->nip, UkomStatus::SELESAI)) {
            throw new BusinessException([
                "message" => "Masih Ada Pendaftaran Ukom yang masih Aktif",
                "error code" => "UKOM-00001",
                "code" => 500
            ], 500);
        }

        $systemConfiguration = SystemConfiguration::find("file_persyaratan_ukom");
        $filePersyaratan = $systemConfiguration->property[str_replace('user_', '', $userContext->role_code)]['perpindahan'];
        foreach ($filePersyaratan['values'] as $key => $value) {
            $validation[str_replace(' ', '_', strtolower($value))] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);

        DB::transaction(function () use ($request, $userContext, $ukom, $filePersyaratan) {
            $ukom->fill($request->all());
            $ukom->nip = $userContext->nip;
            $ukom->email = $userContext->userDetail->email;
            $ukom->angka_kredit = $userContext->pak->angka_kredit;
            $ukom->name = $userContext->name;
            $ukom->jenis = "perpindahan";
            $ukom->status = UkomStatus::PENDAFTARAN;
            $ukom->task_status = TaskStatus::PENDING;
            $ukom->jabatan_code = $userContext->jabatan->jabatan_code;
            $ukom->jenjang_code = $userContext->jabatan->jenjang_code;
            $ukom->pangkat_id = $userContext->pangkat->pangkat_id;
            $ukom->tujuan_jenjang_code = $ukom->jabatan_code;
            $ukom->tujuan_jabatan_code = $request->tujuan_jabatan_code;
            $ukom->tujuan_pangkat_id = $ukom->pangkat_id;
            $ukom->instansi_id = $userContext->instansi_id;
            $ukom->unit_kerja_id = $userContext->unit_kerja_id;
            $ukom->detail = [
                'karpeg' => $userContext->userDetail->karpeg,
                'tmt_jabatan' => $userContext->jabatan->tmt,
                'tmt_pangkat' => $userContext->pangkat->tmt,
                'tempat_lahir' => $userContext->userDetail->tempat_lahir,
                'tanggal_lahir' => $userContext->userDetail->tanggal_lahir,
                'jenis_kelamin' => $userContext->userDetail->jenis_kelamin,
                'jabatan_name' => $userContext->jabatan->jabatan->name,
                'jenjang_name' => $userContext->jabatan->jenjang->name,
                'pangkat_name' => $userContext->pangkat->pangkat->name,
                'tujuan_jabatan_name' => $userContext->jabatan->jabatan->name,
                'tujuan_jenjang_name' => $userContext->jabatan->jenjang->name,
                'tujuan_pangkat_name' => Pangkat::where('id', $ukom->pangkat_id + 1)->first()->name ?? "",
                'instansi_name' => $userContext->instansi->name,
                'unit_kerja_name' => $userContext->unitKerja->name,
                'provinsi_name' => $userContext->instansi->provinsi->name ?? null,
                'kabupaten_name' => $userContext->instansi->kabupaten->name ?? null,
                'kota_kota' => $userContext->instansi->kota->name ?? null,
                'unit_kerja_alamat' => $userContext->unitKerja->alamat,
                'pendidikan' => $userContext->pendidikan->level,
                'jurusan' => $userContext->pendidikan->jurusan,
            ];
            $ukom->customSaveWithUpload($request->all(), $filePersyaratan['values']);

            AuditTimeline::create([
                'association' => 'tbl_ukom',
                'association_key' => $ukom->id,
                'description' => 'Menunggu Hasil Pendaftaran'
            ]);
        });

        return redirect()->route('/ukom/pendaftaran_ukom');
    }

    public function promosiStore(Request $request, $validation = [])
    {
        $validation['ukom_periode_id'] = 'required';
        $validation['type'] = 'required';
        $validation['tujuan_jabatan_code'] = 'required';
        $ukom = new UkomService();

        if ($ukom->findByNipAndStatusNot($request->nip, UkomStatus::SELESAI)) {
            throw new BusinessException([
                "message" => "Masih Ada Pendaftaran Ukom yang masih Aktif",
                "error code" => "UKOM-00001",
                "code" => 500
            ], 500);
        }

        $systemConfiguration = SystemConfiguration::find("file_persyaratan_ukom");
        $filePersyaratan = $systemConfiguration->property[$request->tipe_user]['promosi'];
        foreach ($filePersyaratan['values'] as $key => $value) {
            $validation[str_replace(' ', '_', strtolower($value))] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);

        return DB::transaction(function () use ($request, $ukom, $filePersyaratan) {
            $jabatan = new JabatanService();
            $pangkat = new PangkatService();
            $instansi = new InstansiService();
            $unitKerja = new UnitKerjaService();

            $tujuanJabatan = $jabatan->findById($request->tujuan_jabatan_code);
            $pankgat = $pangkat->findById($request->pangkat_id);
            $unitKerja = $unitKerja->findById($request->unit_kerja_id);
            $instansi = $unitKerja->instansi;

            $ukom->fill($request->all());
            $ukom->nip = $request->nip;
            $ukom->email = $request->email;
            $ukom->angka_kredit = $request->angka_kredit;
            $ukom->name = $request->name;
            $ukom->jenis = "promosi";
            $ukom->status = UkomStatus::PENDAFTARAN;
            $ukom->task_status = TaskStatus::PENDING;
            $ukom->pangkat_id = $pankgat->id;
            $ukom->tujuan_jenjang_code = 'pemula';
            $ukom->tujuan_jabatan_code = $tujuanJabatan->code;
            $ukom->tujuan_pangkat_id = $ukom->pangkat_id;
            $ukom->instansi_id = $instansi->id;
            $ukom->unit_kerja_id = $unitKerja->id;
            $ukom->detail = [
                'karpeg' => $request->karpeg,
                'tmt_cpns' => $request->tmt_cpns,
                'tmt_jabatan' => $request->tmt_jabatan,
                'tmt_pangkat' => $request->tmt_pangkat,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'jabatan_name' => $request->jabatan_name,
                'jenjang_name' => $request->jenjang_name,
                'pangkat_name' => $pankgat->name,
                'tujuan_jabatan_name' => $tujuanJabatan->name,
                'tujuan_jenjang_name' => 'pemula',
                'tujuan_pangkat_name' => $pankgat->name,
                'instansi_name' => $instansi->name,
                'unit_kerja_name' => $unitKerja->name,
                'provinsi_name' => $unitKerja->instansi->provinsi->name ?? null,
                'kabupaten_name' => $unitKerja->instansi->kabupaten->name ?? null,
                'kota_kota' => $unitKerja->instansi->kota->name ?? null,
                'unit_kerja_alamat' => $unitKerja->alamat,
                'pendidikan' => $request->pendidikan,
                'jurusan' => $request->jurusan,
            ];
            $ukom->customSaveWithUpload($request->all(), $filePersyaratan['values']);

            AuditTimeline::create([
                'association' => 'tbl_ukom',
                'association_key' => $ukom->id,
                'description' => 'Menunggu Hasil Pendaftaran'
            ]);

            return $ukom;
        });
    }

    public function perpindahanJabatanNonJFStore(Request $request, $validation = [])
    {

        $validation['ukom_periode_id'] = 'required';
        $validation['type'] = 'required';
        $validation['tujuan_jabatan_code'] = 'required';
        $ukom = new UkomService();

        if ($ukom->findByNipAndStatusNot($request->nip, UkomStatus::SELESAI)) {
            throw new BusinessException([
                "message" => "Masih Ada Pendaftaran Ukom yang masih Aktif",
                "error code" => "UKOM-00001",
                "code" => 500
            ], 500);
        }

        $systemConfiguration = SystemConfiguration::find("file_persyaratan_ukom");
        $filePersyaratan = $systemConfiguration->property[$request->tipe_user]['perpindahan'];
        foreach ($filePersyaratan['values'] as $key => $value) {
            $validation[str_replace(' ', '_', strtolower($value))] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);

        return DB::transaction(function () use ($request, $ukom, $filePersyaratan) {
            $jabatan = new JabatanService();
            $pangkat = new PangkatService();
            $instansi = new InstansiService();
            $unitKerja = new UnitKerjaService();

            $tujuanJabatan = $jabatan->findById($request->tujuan_jabatan_code);
            $pankgat = $pangkat->findById($request->pangkat_id);
            $unitKerja = $unitKerja->findById($request->unit_kerja_id);
            $instansi = $unitKerja->instansi;

            $ukom->fill($request->all());
            $ukom->nip = $request->nip;
            $ukom->email = $request->email;
            $ukom->angka_kredit = $request->angka_kredit;
            $ukom->name = $request->name;
            $ukom->jenis = "perpindahan";
            $ukom->status = UkomStatus::PENDAFTARAN;
            $ukom->task_status = TaskStatus::PENDING;
            $ukom->pangkat_id = $pankgat->id;
            $ukom->tujuan_jenjang_code = 'pemula';
            $ukom->tujuan_jabatan_code = $tujuanJabatan->code;
            $ukom->tujuan_pangkat_id = $ukom->pangkat_id;
            $ukom->instansi_id = $instansi->id;
            $ukom->unit_kerja_id = $unitKerja->id;
            $ukom->detail = [
                'karpeg' => $request->karpeg,
                'tmt_cpns' => $request->tmt_cpns,
                'tmt_jabatan' => $request->tmt_jabatan,
                'tmt_pangkat' => $request->tmt_pangkat,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'jabatan_name' => $request->jabatan_name,
                'jenjang_name' => $request->jenjang_name,
                'pangkat_name' => $pankgat->name,
                'tujuan_jabatan_name' => $tujuanJabatan->name,
                'tujuan_jenjang_name' => 'pemula',
                'tujuan_pangkat_name' => $pankgat->name,
                'instansi_name' => $instansi->name,
                'unit_kerja_name' => $unitKerja->name,
                'provinsi_name' => $unitKerja->instansi->provinsi->name ?? null,
                'kabupaten_name' => $unitKerja->instansi->kabupaten->name ?? null,
                'kota_kota' => $unitKerja->instansi->kota->name ?? null,
                'unit_kerja_alamat' => $unitKerja->alamat,
                'pendidikan' => $request->pendidikan,
                'jurusan' => $request->jurusan,
            ];
            $ukom->customSaveWithUpload($request->all(), $filePersyaratan['values']);

            AuditTimeline::create([
                'association' => 'tbl_ukom',
                'association_key' => $ukom->id,
                'description' => 'Menunggu Hasil Pendaftaran'
            ]);

            return $ukom;
        });
    }

    public function daftarUkomNonJF(Request $request)
    {
        $validation = [
            'ukom_periode_id' => 'required',
            'type' => 'required',
            'nip' => 'required|string|size:18|regex:/^[0-9]+$/',
            'name' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan' => 'required',
            'jurusan' => 'required',
            'unit_kerja_id' => 'required',
            'karpeg' => 'required',
            'tmt_cpns' => 'required',
            'jabatan_name' => 'required',
            'tmt_jabatan' => 'required',
            'tujuan_jabatan_code' => 'required',
            'pangkat_id' => 'required',
            'tmt_pangkat' => 'required',
            'angka_kredit' => 'required',
            'jenis_ukom' => 'required',
            'tipe_user' => 'required',
        ];

        $ukom = null;
        if ($request->jenis_ukom == "promosi") {
            $ukom = $this->promosiStore($request, $validation);
        } else if ($request->jenis_ukom == "perpindahan") {
            $ukom = $this->perpindahanJabatanNonJFStore($request, $validation);
        }

        return redirect()->route('/page/ukom/detail', ['pendaftaran_code' => $ukom->pendaftaran_code]);
    }

    public function perbaikan(Request $request)
    {
        $ukom = new UkomService();
        $ukom = $ukom->findById($request->id);

        foreach ($ukom->storage as $key => $storage) {
            if ($storage->task_status != TaskStatus::APPROVE) {
                $request->validate(['storage' => 'required']);
            }
        }

        DB::transaction(function () use ($request, $ukom) {
            $ukom->task_status = TaskStatus::PENDING;
            $ukom->customUpdateWithUpload($request->all());

            AuditTimeline::create([
                'association' => 'tbl_ukom',
                'association_key' => $ukom->id,
                'description' => 'Menunggu Hasil Perbaikan Pendaftaran'
            ]);
        });

        return redirect()->back();
    }

    public function perbaikanNonJF(Request $request)
    {
        $ukom = new UkomService();
        $user = new UserService();

        $ukom = $ukom->findById($request->id);

        if (!$user->findById($ukom->nip)) {
            foreach ($ukom->storage as $key => $storage) {
                if ($storage->task_status != TaskStatus::APPROVE) {
                    $request->validate(['storage' => 'required']);
                }
            }

            DB::transaction(function () use ($request, $ukom) {
                $ukom->task_status = TaskStatus::PENDING;
                $ukom->customUpdateWithUpload($request->all());

                AuditTimeline::create([
                    'association' => 'tbl_ukom',
                    'association_key' => $ukom->id,
                    'description' => 'Menunggu Hasil Perbaikan Pendaftaran'
                ]);
            });
        }

        return redirect()->back();
    }

    public function riwayatUkom()
    {
        $userContext = auth()->user();

        $ukom = new UkomService();
        $data = [];
        $data['attr']['ukom_mansoskul_id'] = 'null';
        $data['attr']['ukom_teknis_id'] = 'null';
        $data['attr']['delete_flag'] = false;
        $data['attr']['nip'] = $userContext->nip;

        $data['cond']['delete_flag'] = '=';
        $data['cond']['ukom_teknis_id'] = '!=';
        $data['cond']['ukom_mansoskul_id'] = '!=';
        $ukomList = $ukom->findSearchPaginate($data);

        return view('ukom.riwayat_ukom', compact(
            'ukomList'
        ));
    }

    public function riwayatUkomDetail(Request $request)
    {
        $ukom = new UkomService();
        $ukom = $ukom->findById($request->id);

        return view('ukom.riwayat_ukom_detail', compact(
            'ukom'
        ));
    }

    public function pemetaanUkom(Request $request)
    {
        $ukom = new UkomService();
        $ukomPeriode = new UkomPeriodeService();
        $provinsi = new ProvinsiService();
        $kabKota = new KabKotaService();
        $instansi = new InstansiService();
        $unitKerja = new UnitKerjaService();
        $data = $request->all();

        $data['attr']['ukom_mansoskul_id'] = 'null';
        $data['attr']['ukom_teknis_id'] = 'null';
        $data['attr']['delete_flag'] = false;

        $data['cond']['delete_flag'] = '=';
        $data['cond']['ukom_mansoskul_id'] = '!=';
        $data['cond']['ukom_teknis_id'] = '!=';
        $data['cond']['ukom_periode_id'] = '=';
        $ukomList = $ukom->findSearchPaginate($data);

        $ukomPeriodeList = $ukomPeriode->findAllExcludeInactiveFlag();
        $provinsiList = $provinsi->findAll();
        $kabkotaList = $kabKota->findAll();
        $instansiList = $instansi->findAll();
        $unitkerjaList = $unitKerja->findAll();
        return view('ukom.pemetaan_ukom', compact(
            'ukomList',
            'ukomPeriodeList',
            'provinsiList',
            'kabkotaList',
            'instansiList',
            'unitkerjaList',
        ));
    }

    public function pemetaanUkomDetail(Request $request)
    {
        $ukom = new UkomService();
        $ukom = $ukom->findById($request->id);

        return view('ukom.pemetaan_ukom_detail', compact(
            'ukom'
        ));
    }

    public function uploadRekomendasi(Request $request)
    {
        $request->validate(['file_rekomendasi' => 'required|mimes:pdf|max:2048']);
        DB::transaction(function () use ($request) {
            $ukom = new UkomService();
            $ukom = $ukom->findById($request->id);

            $file = $request['file_rekomendasi'];
            $fileName = $ukom->id . '_.' . $file->getClientOriginalExtension();

            $ukom->file_rekomendasi = 'ukom/' . $fileName;
            $ukom->customUpdate();

            AuditTimeline::create([
                'association' => 'tbl_ukom',
                'association_key' => $ukom->id,
                'description' => 'penerbitan surat rekomendasi'
            ]);

            $storage = new LocalStorageService();
            $storage->putObject('ukom', $fileName, $file);
        });

        return redirect()->back();
    }

    public function daftarPendaftaran(Request $request)
    {
        $ukom = new UkomService();
        $ukomPeriode = new UkomPeriodeService();
        $provinsi = new ProvinsiService();
        $kabKota = new KabKotaService();
        $instansi = new InstansiService();
        $unitKerja = new UnitKerjaService();
        $ukomPeriodeList = $ukomPeriode->findAllExcludeInactiveFlag();

        $data = $request->all();
        $data['cond']['ukom_periode_id'] = '=';
        $data['cond']['unitKerja']['provinsi_id'] = '=';
        $data['cond']['unitKerja']['kab_kota_id'] = '=';
        $data['cond']['unitKerja']['instansi_id'] = '=';
        $data['cond']['unitkerja_id'] = '=';
        if (!isset($data['attr']['ukom_periode_id']) && $ukomPeriodeList && count($ukomPeriodeList) > 0) {
            $data['attr']['ukom_periode_id'] = $ukomPeriodeList[0]->id;
        }
        if (!isset($data['attr']['task_status'])) {
            $data['attr']['task_status'] = TaskStatus::REJECT;
            $data['cond']['task_status'] = '!=';
        } else {
            $data['cond']['task_status'] = '=';
        }
        $ukomList = $ukom->findSearchPaginate($data);
        $provinsiList = $provinsi->findAll();
        $kabKotaList = $kabKota->findAll();
        $instansiList = $instansi->findAll();
        $unitKerjaList = $unitKerja->findAll();

        return view('ukom.daftar_pendaftaran', compact(
            'ukomList',
            'ukomPeriodeList',
            'provinsiList',
            'kabKotaList',
            'instansiList',
            'unitKerjaList',
        ));
    }

    public function daftarPendaftaranDetail(Request $request)
    {
        $ukom = new UkomService();
        $userPendidikan = new UserPendidikanService();
        $userPak = new UserPakService();
        $userKompetensi = new UserKompetensiService();

        $ukom = $ukom->findById($request->id);
        $user = $ukom->user;
        $userPendidikanList = $userPendidikan->findAllByTaskStatus(TaskStatus::APPROVE);
        $userPakList = $userPak->findAllByTaskStatus(TaskStatus::APPROVE);
        $userKompetensiList = $userKompetensi->findAllByTaskStatus(TaskStatus::APPROVE);

        return view('ukom.daftar_pendaftaran_detail', compact(
            'ukom',
            'user',
            'userPendidikanList',
            'userPakList',
            'userKompetensiList',
        ));
    }

    public function approvalPendaftaran(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'task_status' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $ukom = new UkomService();

            $ukom = $ukom->findById($request->id);
            if ($request->task_status == TaskStatus::APPROVE) {
                $ukom->task_status = TaskStatus::APPROVE;

                foreach ($request['storage'] as $id => $value) {
                    if ($value != TaskStatus::APPROVE) {
                        throw new BusinessException([
                            "message" => "Permintaan tidak dapat diterima",
                            "error code" => "UKOM-00002",
                            "code" => 500
                        ], 500);
                    } else {
                        $storage = new StorageService();
                        $storage = $storage->findById((int)$id);
                        $storage->task_status = $value;
                        $storage->customSave();
                    }
                }
                AuditTimeline::create([
                    'association' => 'tbl_ukom',
                    'association_key' => $ukom->id,
                    'description' => 'Pendaftaran Diterima'
                ]);
            } else if ($request->task_status == TaskStatus::REJECT) {
                $ukom->task_status = TaskStatus::REJECT;
                $ukom->comment = $request->comment ?? null;

                foreach ($request['storage'] as $id => $value) {
                    $storage = new StorageService();
                    $storage = $storage->findById((int)$id);
                    $storage->task_status = $value;
                    $storage->customSave();
                }
                AuditTimeline::create([
                    'association' => 'tbl_ukom',
                    'association_key' => $ukom->id,
                    'description' => $ukom->comment ?? 'Pendaftaran Ditolak'
                ]);
            }
            $ukom->customUpdate();
        });


        return redirect()->route('/ukom/pendaftaran');
    }

    public function importNilai()
    {
        $ukomPeriode = new UkomPeriodeService();

        $ukomPeriodeList = $ukomPeriode->findAllExcludeInactiveFlag();
        return view('ukom.import_nilai', compact(
            'ukomPeriodeList'
        ));
    }

    public function importNilaiTemplateMansoskul()
    {
        return response()->download(Storage::path('public/template/mansoskul_template.xlsx'), 'mansoskul_template.xlsx');
    }

    public function importNilaiTemplateTeknis()
    {
        return response()->download(Storage::path('public/template/teknis_template.xlsx'), 'teknis_template.xlsx');
    }

    public function importNilaiStore(Request $request)
    {
        $request->validate([
            'ukom_periode_id' => 'required',
            'file_teknis' => 'required|mimes:xls,xlsx',
            'file_mansoskul' => 'required|mimes:xls,xlsx',
        ]);

        DB::transaction(function () use ($request) {
            Excel::import(new UkomMansoskulImport($request->ukom_periode_id), $request->file('file_mansoskul'));
            Excel::import(new UkomTeknisImport($request->ukom_periode_id), $request->file('file_teknis'));
        });

        return redirect()->route('/ukom/pemetaan_ukom');
    }

    public function daftarUkomEksternal(Request $request)
    {
        return null;
    }
}
