<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Eyegil\SecurityBase\Models\User;
use Eyegil\SecurityBase\Models\UserApplicationChannel;
use Eyegil\SecurityBase\Models\UserRole;
use Eyegil\SecurityPassword\Models\Password;
use Eyegil\SijupriMaintenance\Models\Instansi;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Eyegil\SijupriMaintenance\Models\KategoriPengembangan;
use Eyegil\SijupriMaintenance\Models\KategoriSertifikasi;
use Eyegil\SijupriMaintenance\Models\Pangkat;
use Eyegil\SijupriMaintenance\Models\Pendidikan;
use Eyegil\SijupriMaintenance\Models\PredikatKinerja;
use Eyegil\SijupriMaintenance\Models\RatingKinerja;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Eyegil\SijupriMaintenance\Models\Wilayah;
use Eyegil\SijupriSiap\Dtos\RiwayatJabatanDto;
use Eyegil\SijupriSiap\Dtos\RiwayatKinerjaDto;
use Eyegil\SijupriSiap\Dtos\RiwayatKompetensiDto;
use Eyegil\SijupriSiap\Dtos\RiwayatPangkatDto;
use Eyegil\SijupriSiap\Dtos\RiwayatPendidikanDto;
use Eyegil\SijupriSiap\Dtos\RiwayatSertifikasiDto;
use Eyegil\SijupriSiap\Models\JF;
use Eyegil\SijupriSiap\Models\RiwayatJabatan;
use Eyegil\SijupriSiap\Models\RiwayatKinerja;
use Eyegil\SijupriSiap\Models\RiwayatKompetensi;
use Eyegil\SijupriSiap\Models\RiwayatPangkat;
use Eyegil\SijupriSiap\Models\RiwayatPendidikan;
use Eyegil\SijupriSiap\Models\RiwayatSertifikasi;
use Eyegil\SijupriSiap\Models\UserInstansi;
use Eyegil\SijupriSiap\Models\UserUnitKerja;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class V2MigrationSeeder extends Seeder
{
    public static function run(): void
    {
        try {
            DB::transaction(function () {
                $jabatanCodeList = [
                    "penera" => "JB11",
                    "pengamat_tera" => "JB10",
                    "pranata_lab_kemetrologian" => "JB9",
                    "pengawas_kemetrologian" => "JB8",
                    "penguji_mutu_barang" => "JB7",
                    "analis_investigasi_dan_pengamanan_perdagangan" => "JB6",
                    "negosiator_perdagangan" => "JB5",
                    "pengawas_perdagangan" => "JB4",
                    "pemeriksa_perdagangan_berjangka_komoditi" => "JB3",
                    "penjamin_mutu_produk" => "JB2",
                    "analis_perdagangan" => "JB1",
                ];

                $jenjangCodeList = [
                    "pemula" => "JJ1",
                    "terampil" => "JJ2",
                    "mahir" => "JJ3",
                    "penyelia" => "JJ4",
                    "pertama" => "JJ5",
                    "muda" => "JJ6",
                    "madya" => "JJ7",
                    "utama" => "JJ8",
                ];

                $pendidikanCodeList = [
                    "S1" => "PD3",
                    "S2" => "PD4",
                    "SMA" => "PD1",
                    "D3" => "PD2",
                    "S3" => "PD5",
                ];

                function assignChannels($user_id, $application_code)
                {
                    $channels = [];
                    foreach (["WEB", "MOBILE"] as $channel_code) {
                        $channels[] = [
                            'id' => Str::uuid(),
                            'user_id' => $user_id,
                            'application_code' => $application_code,
                            'channel_code' => $channel_code
                        ];
                    }
                    UserApplicationChannel::insert($channels);
                }

                function assignUserInstansi(User $user, $oldUser)
                {
                    $oldInstansi = DB::table('tbl_instansi')->where('id', $oldUser->instansi_id)->first();
                    $instansi = Instansi::where("name", $oldInstansi->name)->first();


                    $userInstansi = new UserInstansi();
                    $userInstansi->date_created = $oldUser->created_at ?? Carbon::now();
                    $userInstansi->last_updated = $oldUser->updated_at ?? null;
                    $userInstansi->jenis_kelamin_code = null;
                    $userInstansi->instansi_id = $instansi->id;
                    $userInstansi->nip = $user->id;
                    $userInstansi->save();
                }

                function assignUserUnitKerja(User $user, $oldUser)
                {
                    $oldUnitKerja = DB::table('tbl_unit_kerja')->where('id', $oldUser->unit_kerja_id)->first();
                    $unitKerja = UnitKerja::where("name", $oldUnitKerja->name)->first();
                    if (!$unitKerja) {
                        $oldInstansi = DB::table('tbl_instansi')->where('id', $oldUser->instansi_id)->first();
                        $oldWilayah = DB::table('tbl_wilayah')->where('code', $oldUnitKerja->wilayah_code)->first();
                        //instansi & wilayah will never null
                        $instansi = Instansi::where("name", $oldInstansi->name)->first();
                        $wilayah = Wilayah::where("name", $oldWilayah->region ?? "Jawa")->first();

                        $unitKerja = new UnitKerja();
                        $unitKerja->fromArray((array) $oldUnitKerja);
                        $unitKerja->date_created = $oldUnitKerja->created_at ?? Carbon::now();
                        $unitKerja->last_updated = $oldUnitKerja->updated_at ?? null;
                        $unitKerja->instansi_id = $instansi->id;
                        $unitKerja->wilayah_code = $wilayah->code;
                        $unitKerja->saveWithUuid();
                    }

                    $userUnitKerja = new UserUnitKerja();
                    $userUnitKerja->date_created = $oldUser->created_at ?? Carbon::now();
                    $userUnitKerja->last_updated = $oldUser->updated_at ?? null;
                    $userUnitKerja->jenis_kelamin_code = null;
                    $userUnitKerja->unit_kerja_id = $unitKerja->id;
                    $userUnitKerja->nip = $user->id;
                    $userUnitKerja->save();
                }

                function assignJF(User $user, $oldUser, $oldUserDetail, $jabatanCodeList, $jenjangCodeList, $pendidikanCodeList)
                {
                    $workflowService = app()->make(WorkflowService::class);
                    $storageService = app()->make(StorageService::class);

                    $oldUnitKerja = DB::table('tbl_unit_kerja')->where('id', $oldUser->unit_kerja_id)->first();
                    $unitKerja = UnitKerja::where("name", $oldUnitKerja->name)->first();
                    if (!$unitKerja) {
                        $oldInstansi = DB::table('tbl_instansi')->where('id', $oldUnitKerja->instansi_id)->first();
                        $oldWilayah = DB::table('tbl_wilayah')->where('code', $oldUnitKerja->wilayah_code)->first();
                        //instansi & wilayah will never null
                        $instansi = Instansi::where("name", $oldInstansi->name)->first();
                        $wilayah = Wilayah::where("name", $oldWilayah->region)->first();

                        $unitKerja = new UnitKerja();
                        $unitKerja->fromArray((array) $oldUnitKerja);
                        $unitKerja->date_created = $oldUnitKerja->created_at ?? Carbon::now();
                        $unitKerja->last_updated = $oldUnitKerja->updated_at ?? null;
                        $unitKerja->instansi_id = $instansi->id;
                        $unitKerja->wilayah_code = $wilayah->code;
                        $unitKerja->saveWithUuid();
                    }

                    if ($oldUserDetail) {
                        $jf = new JF();
                        $jf->fromArray((array) $oldUserDetail);
                        $jf->date_created = $oldUserDetail->created_at ?? Carbon::now();
                        $jf->last_updated = $oldUserDetail->updated_at ?? null;
                        $jf->jenis_kelamin_code = $oldUserDetail->jenis_kelamin != null ? ($oldUserDetail->jenis_kelamin == "Pria" ? "M" : "F") : null;
                        $jf->ktp = $oldUserDetail->file_ktp;
                        $jf->nip = $user->id;
                        $jf->unit_kerja_id = $unitKerja->id;
                        $jf->save();
                    } else {
                        $jf = new JF();
                        $jf->date_created = Carbon::now();
                        $jf->jenis_kelamin_code = null;
                        $jf->nip = $user->id;
                        $jf->unit_kerja_id = $unitKerja->id;
                        $jf->save();
                    }

                    $oldUserPendidikanList = DB::table('tbl_user_pendidikan')->where("nip", $oldUser->nip)->get();
                    foreach ($oldUserPendidikanList as $key => $oldUserPendidikan) {
                        if ($oldUserPendidikan->task_status == "APPROVE") {
                            $rwPendidikan = new RiwayatPendidikan();
                            $rwPendidikan->fromArray((array) $oldUserPendidikan);
                            $rwPendidikan->date_created = $oldUserPendidikan->created_at ?? Carbon::now();
                            $rwPendidikan->last_updated = $oldUserPendidikan->updated_at ?? null;
                            $rwPendidikan->institusi_pendidikan = $oldUserPendidikan->instansi_pendidikan;
                            $rwPendidikan->tanggal_ijazah = $oldUserPendidikan->bulan_kelulusan;
                            $rwPendidikan->pendidikan_code = $pendidikanCodeList[$oldUserPendidikan->level];
                            $rwPendidikan->ijazah = str_replace("pendidikan/", "", $oldUserPendidikan->file_ijazah);
                            $rwPendidikan->saveWithUUid();
                        } else {
                            $riwayatPendidikanDto = new RiwayatPendidikanDto();
                            $riwayatPendidikanDto->nip = $user->id;
                            $riwayatPendidikanDto->fromArray((array) $oldUserPendidikan);
                            $riwayatPendidikanDto->institusi_pendidikan = $oldUserPendidikan->instansi_pendidikan;
                            $riwayatPendidikanDto->tanggal_ijazah = $oldUserPendidikan->bulan_kelulusan;
                            $riwayatPendidikanDto->pendidikan_code = $pendidikanCodeList[$oldUserPendidikan->level];

                            $riwayatPendidikanDto->ijazah = str_replace("pendidikan/", "", $oldUserPendidikan->file_ijazah);
                            $riwayatPendidikanDto->ijazah_url = $storageService->getUrl("system", "jf", $riwayatPendidikanDto->ijazah);

                            $pendidikan = Pendidikan::findOrThrowNotFound($riwayatPendidikanDto->pendidikan_code);
                            $riwayatPendidikanDto->pendidikan_name = $pendidikan->name;
                            $pendingTask = $workflowService->startCreateTask(
                                "rw_pendidikan_task",
                                Str::uuid(),
                                $pendidikan->name,
                                [],
                                $riwayatPendidikanDto,
                                $user->id
                            );
                        }
                    }

                    $oldUserPangkatList = DB::table('tbl_user_pangkat')->where("nip", $oldUser->nip)->get();
                    foreach ($oldUserPangkatList as $key => $oldUserPangkat) {
                        if ($oldUserPangkat->task_status == "APPROVE") {
                            $rwPangkat = new RiwayatPangkat();
                            $rwPangkat->fromArray((array) $oldUserPangkat);
                            $rwPangkat->date_created = $oldUserPangkat->created_at ?? Carbon::now();
                            $rwPangkat->last_updated = $oldUserPangkat->updated_at ?? null;
                            $rwPangkat->pangkat_code = "PK" . $oldUserPangkat->pangkat_id;
                            $rwPangkat->sk_pangkat = str_replace("jabatan/", "", $oldUserPangkat->file_sk_pangkat);
                            $rwPangkat->saveWithUUid();
                        } else {
                            $riwayatPangkatDto = new RiwayatPangkatDto();
                            $riwayatPangkatDto->fromArray((array) $oldUserPangkat);
                            $riwayatPangkatDto->nip = $user->id;
                            $riwayatPangkatDto->pangkat_code = "PK" . $oldUserPangkat->pangkat_id;

                            $riwayatPangkatDto->sk_pangkat = str_replace("jabatan/", "", $oldUserPangkat->file_sk_pangkat);
                            $riwayatPangkatDto->sk_pangkat_url = $storageService->getUrl("system", "jf", $riwayatPangkatDto->sk_pangkat);
                            $riwayatPangkatDto->file_sk_pangkat = null;

                            $pangkat = Pangkat::findOrThrowNotFound($riwayatPangkatDto->pangkat_code);
                            $riwayatPangkatDto->pangkat_name = $pangkat->name;
                            $pendingTask = $workflowService->startCreateTask(
                                "rw_pangkat_task",
                                $riwayatPangkatDto->id,
                                $pangkat->name,
                                [],
                                $riwayatPangkatDto,
                                $user->id
                            );
                        }
                    }

                    $oldUserJabatanList = DB::table('tbl_user_jabatan')->where("nip", $oldUser->nip)->get();
                    foreach ($oldUserJabatanList as $key => $oldUserJabatan) {
                        if ($oldUserJabatan->task_status == "APPROVE") {
                            $rwJabtan = new RiwayatJabatan();
                            $rwJabtan->fromArray((array) $oldUserJabatan);
                            $rwJabtan->date_created = $oldUserJabatan->created_at ?? Carbon::now();
                            $rwJabtan->last_updated = $oldUserJabatan->updated_at ?? null;
                            $rwJabtan->jabatan_code = $jabatanCodeList[$oldUserJabatan->jabatan_code];
                            $rwJabtan->jenjang_code = $jenjangCodeList[$oldUserJabatan->jenjang_code];
                            $rwJabtan->sk_jabatan = str_replace("jabatan/", "", $oldUserJabatan->file_sk_jabatan);
                            $rwJabtan->saveWithUUid();
                        } else {
                            $riwayatJabatanDto = new RiwayatJabatanDto();
                            $riwayatJabatanDto->nip = $user->id;
                            $riwayatJabatanDto->fromArray((array) $oldUserJabatan);
                            $riwayatJabatanDto->jabatan_code = $jabatanCodeList[$oldUserJabatan->jabatan_code];
                            $riwayatJabatanDto->jenjang_code = $jenjangCodeList[$oldUserJabatan->jenjang_code];

                            $riwayatJabatanDto->sk_jabatan = str_replace("jabatan/", "", $oldUserJabatan->file_sk_jabatan);
                            $riwayatJabatanDto->sk_jabatan_url = $storageService->getUrl("system", "jf", $riwayatJabatanDto->sk_jabatan);
                            $riwayatJabatanDto->file_sk_jabatan = null;

                            $jabatan = Jabatan::findOrThrowNotFound($riwayatJabatanDto->jabatan_code);
                            $jenjang = Jenjang::findOrThrowNotFound($riwayatJabatanDto->jenjang_code);
                            $riwayatJabatanDto->jenjang_name = $jenjang->name;
                            $riwayatJabatanDto->jabatan_name = $jabatan->name;

                            $pendingTask = $workflowService->startCreateTask(
                                "rw_jabatan_task",
                                Str::uuid(),
                                $jabatan->name . " | " . $jenjang->name,
                                [],
                                $riwayatJabatanDto,
                                $user->id
                            );
                        }
                    }

                    $oldUserKinerjaList = DB::table('tbl_user_pak')->where("nip", $oldUser->nip)->get();
                    foreach ($oldUserKinerjaList as $key => $oldUserKinerja) {
                        if ($oldUserKinerja->task_status == "APPROVE") {
                            $rwKinerja = new RiwayatKinerja();
                            $rwKinerja->fromArray((array) $oldUserKinerja);
                            $rwKinerja->date_created = $oldUserKinerja->created_at ?? Carbon::now();
                            $rwKinerja->last_updated = $oldUserKinerja->updated_at ?? null;
                            $rwKinerja->date_start = $oldUserKinerja->tgl_mulai;
                            $rwKinerja->date_end = $oldUserKinerja->tgl_selesai;
                            $rwKinerja->type = $oldUserKinerja->periode == 1 ? "bulanan" : "tahunan";
                            $rwKinerja->rating_kinerja_id = RatingKinerja::where("name", $oldUserKinerja->nilai_kinerja)->first()->id;
                            $rwKinerja->rating_hasil_id = RatingKinerja::where("name", $oldUserKinerja->nilai_perilaku)->first()->id;
                            $rwKinerja->predikat_kinerja_id = PredikatKinerja::where("name", $oldUserKinerja->predikat)->first()->id;
                            $rwKinerja->angka_kredit = $oldUserKinerja->angka_kredit;
                            $rwKinerja->doc_penetapan_ak = str_replace("pak/", "", $oldUserKinerja->file_doc_ak);
                            $rwKinerja->doc_evaluasi = str_replace("pak/", "", $oldUserKinerja->file_hasil_eval);
                            $rwKinerja->doc_akumulasi_ak = str_replace("pak/", "", $oldUserKinerja->file_akumulasi_ak);
                            $rwKinerja->doc_predikat = str_replace("pak/", "", $oldUserKinerja->file_dok_konversi);
                            $rwKinerja->saveWithUUid();
                        } else {
                            $riwayatKinerjaDto = new RiwayatKinerjaDto();
                            $riwayatKinerjaDto->fromArray((array) $oldUserKinerja);
                            $riwayatKinerjaDto->nip = $user->id;
                            $riwayatKinerjaDto->date_start = $oldUserKinerja->tgl_mulai;
                            $riwayatKinerjaDto->date_end = $oldUserKinerja->tgl_selesai;
                            $riwayatKinerjaDto->type = $oldUserKinerja->periode == 1 ? "bulanan" : "tahunan";
                            $riwayatKinerjaDto->rating_kinerja_id = RatingKinerja::where("name", $oldUserKinerja->nilai_kinerja)->first()->id;
                            $riwayatKinerjaDto->rating_hasil_id = RatingKinerja::where("name", $oldUserKinerja->nilai_perilaku)->first()->id;
                            $riwayatKinerjaDto->predikat_kinerja_id = PredikatKinerja::where("name", $oldUserKinerja->predikat)->first()->id;
                            $riwayatKinerjaDto->angka_kredit = $oldUserKinerja->angka_kredit;

                            $riwayatKinerjaDto->doc_evaluasi = str_replace("pak/", "", $oldUserKinerja->file_hasil_eval);
                            $riwayatKinerjaDto->doc_evaluasi_url = $storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_evaluasi);

                            $riwayatKinerjaDto->doc_predikat = str_replace("pak/", "", $oldUserKinerja->file_dok_konversi);
                            $riwayatKinerjaDto->doc_predikat_url = $storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_predikat);

                            $riwayatKinerjaDto->doc_akumulasi_ak = str_replace("pak/", "", $oldUserKinerja->file_akumulasi_ak);
                            $riwayatKinerjaDto->doc_akumulasi_ak_url = $storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_akumulasi_ak);

                            $riwayatKinerjaDto->doc_penetapan_ak = str_replace("pak/", "", $oldUserKinerja->file_doc_ak);
                            $riwayatKinerjaDto->doc_penetapan_ak_url = $storageService->getUrl("system", "jf", $riwayatKinerjaDto->doc_penetapan_ak);

                            $ratinHasil = RatingKinerja::findOrThrowNotFound($riwayatKinerjaDto->rating_hasil_id);
                            $riwayatKinerjaDto->rating_hasil_name = $ratinHasil->name;
                            $riwayatKinerjaDto->rating_hasil_value = $ratinHasil->value;

                            $ratinKinerja = RatingKinerja::findOrThrowNotFound($riwayatKinerjaDto->rating_kinerja_id);
                            $riwayatKinerjaDto->rating_kinerja_name = $ratinKinerja->name;
                            $riwayatKinerjaDto->rating_kinerja_value = $ratinKinerja->value;

                            $predikatKinerja = PredikatKinerja::findOrThrowNotFound($riwayatKinerjaDto->predikat_kinerja_id);
                            $riwayatKinerjaDto->predikat_kinerja_name = $predikatKinerja->name;
                            $riwayatKinerjaDto->predikat_kinerja_value = $predikatKinerja->value;

                            $pendingTask = $workflowService->startCreateTask(
                                "rw_kinerja_task",
                                Str::uuid(),
                                $riwayatKinerjaDto->angka_kredit,
                                [],
                                $riwayatKinerjaDto,
                                $user->id
                            );
                        }
                    }

                    $oldUserKompetensiList = DB::table('tbl_user_kompetensi')->where("nip", $oldUser->nip)->get();
                    foreach ($oldUserKompetensiList as $key => $oldUserKompetensi) {
                        if ($oldUserKompetensi->task_status == "APPROVE") {
                            $rwKompetensi = new RiwayatKompetensi();
                            $rwKompetensi->fromArray((array) $oldUserKompetensi);
                            $rwKompetensi->date_created = $oldUserKompetensi->created_at ?? Carbon::now();
                            $rwKompetensi->last_updated = $oldUserKompetensi->updated_at ?? null;
                            $rwKompetensi->date_start = $oldUserKompetensi->tgl_mulai;
                            $rwKompetensi->date_end = $oldUserKompetensi->tgl_selesai;
                            $rwKompetensi->kategori_pengembangan_id = KategoriPengembangan::where('name', $oldUserKompetensi->kategori)->first()->id;
                            $rwKompetensi->sertifikat = str_replace("kompetensi/", "", $oldUserKompetensi->file_sertifikat);
                            $rwKompetensi->saveWithUUid();
                        } else {
                            $riwayatKompetensiDto = new RiwayatKompetensiDto();
                            $riwayatKompetensiDto->fromArray((array) $oldUserKompetensi);
                            $riwayatKompetensiDto->nip = $oldUserDetail->id;
                            $riwayatKompetensiDto->date_start = $oldUserKompetensi->tgl_mulai;
                            $riwayatKompetensiDto->date_end = $oldUserKompetensi->tgl_selesai;
                            $riwayatKompetensiDto->kategori_pengembangan_id = KategoriPengembangan::where('name', $oldUserKompetensi->kategori)->first()->id;

                            $riwayatKompetensiDto->sertifikat = str_replace("kompetensi/", "", $oldUserKompetensi->file_sertifikat);
                            $riwayatKompetensiDto->sertifikat_url = $storageService->getUrl("system", "jf", $riwayatKompetensiDto->sertifikat);
                            $riwayatKompetensiDto->file_sertifikat = null;

                            $kategoriPengemban = KategoriPengembangan::findOrThrowNotFound($riwayatKompetensiDto->kategori_pengembangan_id);
                            $riwayatKompetensiDto->kategori_pengembangan_name = $kategoriPengemban->name;
                            $riwayatKompetensiDto->kategori_pengembangan_value = $kategoriPengemban->value;

                            $pendingTask = $workflowService->startCreateTask(
                                "rw_kompetensi_task",
                                Str::uuid(),
                                $riwayatKompetensiDto->name,
                                [],
                                $riwayatKompetensiDto,
                                $oldUserDetail->id
                            );
                        }
                    }

                    $oldUserSertifikasiList = DB::table('tbl_user_sertifikasi')->where("nip", $oldUser->nip)->get();
                    foreach ($oldUserSertifikasiList as $key => $oldUserSertifikasi) {
                        if ($oldUserSertifikasi->task_status == "APPROVE") {
                            $rwSertifikasi = new RiwayatSertifikasi();
                            $rwSertifikasi->fromArray((array) $oldUserSertifikasi);
                            $rwSertifikasi->date_created = $oldUserSertifikasi->created_at ?? Carbon::now();
                            $rwSertifikasi->last_updated = $oldUserSertifikasi->updated_at ?? null;
                            $rwSertifikasi->date_start = $oldUserSertifikasi->berlaku_mulai;
                            $rwSertifikasi->date_end = $oldUserSertifikasi->berlaku_sampai;
                            $rwSertifikasi->tgl_sk = $oldUserSertifikasi->tanggal_sk;
                            $rwSertifikasi->no_sk = $oldUserSertifikasi->nomor_sk;
                            $rwSertifikasi->kategori_sertifikasi_id = $oldUserSertifikasi->kategori == "Pegawai Berhak" ? "8288756f-1355-4f6e-9903-ce95cfc06ddb" : "8288756f-2355-4f6e-9903-ce95cfc06ddb";
                            $rwSertifikasi->ktp_ppns = str_replace("sertifikasi/", "", $oldUserSertifikasi->file_ktp_ppns);
                            $rwSertifikasi->sk_pengangkatan = str_replace("sertifikasi/", "", $oldUserSertifikasi->file_doc_sk);
                            $rwSertifikasi->saveWithUUid();
                        } else {
                            $riwayatSertifikasiDto = new RiwayatSertifikasiDto();
                            $riwayatSertifikasiDto->fromArray((array) $oldUserSertifikasi);
                            $riwayatSertifikasiDto->nip = $user->id;

                            $riwayatSertifikasiDto->sk_pengangkatan = str_replace("sertifikasi/", "", $oldUserSertifikasi->file_doc_sk);
                            $riwayatSertifikasiDto->sk_pengangkatan_url = $storageService->getUrl("system", "jf", $riwayatSertifikasiDto->sk_pengangkatan);
                            $riwayatSertifikasiDto->file_sk_pengangkatan = null;

                            if ($riwayatSertifikasiDto->file_ktp_ppns) {
                                $riwayatSertifikasiDto->ktp_ppns = str_replace("sertifikasi/", "", $oldUserSertifikasi->file_ktp_ppns);
                                $riwayatSertifikasiDto->ktp_ppns_url = $storageService->getUrl("system", "jf", $riwayatSertifikasiDto->ktp_ppns);
                                $riwayatSertifikasiDto->file_ktp_ppns = null;
                            }
                            $riwayatSertifikasiDto->kategori_sertifikasi_id = $oldUserSertifikasi->kategori == "Pegawai Berhak" ? "8288756f-1355-4f6e-9903-ce95cfc06ddb" : "8288756f-2355-4f6e-9903-ce95cfc06ddb";

                            $kategoriSertifikasi = KategoriSertifikasi::findOrThrowNotFound($riwayatSertifikasiDto->kategori_sertifikasi_id);
                            $riwayatSertifikasiDto->kategori_sertifikasi_name = $kategoriSertifikasi->name;
                            $riwayatSertifikasiDto->kategori_sertifikasi_value = $kategoriSertifikasi->value;
                            $pendingTask = $workflowService->startCreateTask(
                                "rw_sertifikasi_task",
                                $riwayatSertifikasiDto->id,
                                $kategoriSertifikasi->name,
                                [],
                                $riwayatSertifikasiDto,
                                $user->id
                            );
                        }
                    }
                }


                // Migrate User Data
                $oldUserList = DB::table('tbl_user')->get();

                foreach ($oldUserList as $oldUser) {
                    if (!User::where("id", $oldUser->nip)->exists()) {
                        $oldUserDetail = DB::table('tbl_user_detail')->where('nip', $oldUser->nip)->first();

                        $user = new User();
                        $user->fromArray((array) $oldUser);
                        $user->id = $oldUser->nip;
                        $user->date_created = $oldUser->created_at ?? Carbon::now();
                        $user->last_updated = $oldUser->updated_at ?? null;
                        $user->status = $oldUser->user_status;
                        if ($oldUserDetail) {
                            $user->email = $oldUserDetail->email;
                            $user->phone = $oldUserDetail->no_hp;
                        }
                        $user->save();

                        Password::insert([
                            'user_id' => $user->id,
                            'password' => $oldUser->password
                        ]);

                        // Role Mapping
                        $roleMapping = [
                            'super_admin' => ["ADMIN", "sijupri-admin"],
                            'admin_ukom' => ["ADMIN_UKOM", "sijupri-admin"],
                            'admin_pak' => ["ADMIN_PAK", "sijupri-admin"],
                            'admin_formasi' => ["ADMIN_FORMASI", "sijupri-admin"],
                            'admin_akp' => ["ADMIN_AKP", "sijupri-admin"],
                            'bkpsdm_bkd' => ["USER_INSTANSI", "sijupri-instansi"],
                            'opd' => ["USER_UNIT_KERJA", "sijupri-unit-kerja"],
                            'user_external' => ["USER_EXTERNAL", "sijupri-external"],
                            'user_internal' => ["USER_INTERNAL", "sijupri-internal"]
                        ];

                        if (isset($roleMapping[$oldUser->role_code])) {
                            [$role_code, $application_code] = $roleMapping[$oldUser->role_code];

                            UserRole::insert([
                                'id' => Str::uuid(),
                                'user_id' => $user->id,
                                'role_code' => $role_code
                            ]);

                            assignChannels($user->id, $application_code);

                            if ($role_code == "USER_INSTANSI") {
                                assignUserInstansi($user, $oldUser);
                            } else if ($role_code == "USER_UNIT_KERJA") {
                                assignUserUnitKerja($user, $oldUser);
                            } else if ($role_code == "USER_EXTERNAL" || $role_code == "USER_INTERNAL") {
                                assignJF($user, $oldUser, $oldUserDetail, $jabatanCodeList, $jenjangCodeList, $pendidikanCodeList);
                            }
                        }
                    }
                }
            });
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), ['stack' => $th->getTraceAsString()]);

            throw $th;
        }
    }
}
