<?php

namespace App\Http\Controllers\Formasi;

use App\Enums\RoleCode;
use App\Enums\TaskStatus;
use App\Exceptions\BusinessException;
use App\Exports\UnitKerjaFormasiExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Formasi\Service\FormasiDocumentService;
use App\Http\Controllers\Formasi\Service\FormasiPeriodeService;
use App\Http\Controllers\Formasi\Service\FormasiResultService;
use App\Http\Controllers\Formasi\Service\FormasiService;
use App\Http\Controllers\Formasi\Service\FormasiUnsurService;
use App\Http\Controllers\Maintenance\Service\KabKotaService;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use App\Http\Controllers\Maintenance\Service\StorageService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use App\Imports\FormasiImport;
use App\Models\Audit\AuditTimeline;
use App\Models\Formasi\FormasiDokumen;
use App\Models\Formasi\FormasiResult;
use App\Models\Maintenance\Storage as MaintenanceStorage;
use App\Models\Maintenance\SystemConfiguration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class FormasiController extends Controller
{
    private $formasi;

    public function __construct(FormasiService $formasiService)
    {
        $this->formasi = $formasiService;
    }

    public function index(Request $request)
    {
        $userContext = auth()->user();
        $data = $request->all();
        $data['attr']['delete_flag'] = false;
        $data['cond']['delete_flag'] = '=';

        switch ($userContext->role->base) {
            case RoleCode::ADMIN_SIJUPRI:
                $unitKerja = new UnitKerjaService();
                if (($data['attr']['formasi']['rekomendasi_flag'] ?? '') == 'null') {
                    $data['attr']['file_rekomendasi_formasi'] = 'null';
                    unset($data['attr']['formasi']['rekomendasi_flag']);
                }

                $data['cond']['formasi']['rekomendasi_flag'] = '=';
                $data['cond']['file_rekomendasi_formasi'] = '=';
                $unitKerjaList = $unitKerja->findSearchPaginate($data);
                return view('formasi.data_rekomendasi_formasi_sijurpi', compact('unitKerjaList'));
            case RoleCode::PENGATUR_SIAP:
                $formasiList = $this->formasi->findByUnitKerjaIdAndTaskStatus($userContext->unitKerja->id, TaskStatus::APPROVE);
                $formasiListInactive =  $this->formasi->findByUnitKerjaIdAndTaskStatusAndInactiveFlag($userContext->unitKerja->id, TaskStatus::PENDING, true);
                return view('formasi.jabatan.index', compact(
                    'formasiList',
                    'formasiListInactive'
                ));
            case RoleCode::USER:
                $formasiData = $this->formasi->findByUnitKerjaIdAndTaskStatus($userContext->unitKerja->id, TaskStatus::APPROVE);
                return view('formasi.jabatan.detail_2', compact('formasiData'));
        }
    }

    public function riwayatRekomendasi()
    {
        $userContext = auth()->user();

        $formasi = new FormasiService();

        $unitKerja = $userContext->unitKerja;
        $formasiList = $formasi->findRiwayatByUnitKerjaId($userContext->unit_kerja_id);

        return view('formasi.riwayat_rekomendasi', compact(
            'unitKerja',
            'formasiList'
        ));
    }

    public function dataRekomendasiFormasiDetail(Request $request)
    {
        $unitKerja = new UnitKerjaService();
        $unitKerja = $unitKerja->findById($request->id);
        $formasiList = $this->formasi->findAllByUnitKerjaId($unitKerja->id);

        return view('formasi.data_rekomendasi_formasi_detail_sijurpi', compact(
            'unitKerja',
            'formasiList',
        ));
    }

    public function dataRekomendasiFormasiDetailFormasi(Request $request)
    {
        $formasiUnsur = new FormasiUnsurService();

        $formasiData = $this->formasi->findById($request->id);
        $formasiUnsurList = $formasiUnsur->findAllParent($formasiData->jabatan_code);
        return view('formasi.detail', compact('formasiData', 'formasiUnsurList'));
    }

    public function pemetaanFormasi()
    {
        $provinsi = new ProvinsiService();
        $kabKota = new KabKotaService();
        $unitKerja = new UnitKerjaService();
        $provinsiList = $provinsi->findAll();
        $kabKotaList = $kabKota->findAll();
        $unitKerjaList = $unitKerja->findAll();

        return view('formasi.pemetaan_formasi', compact(
            'provinsiList',
            'kabKotaList',
            'unitKerjaList',
        ));
    }

    public function pemetaanFormasiKabKota(Request $request)
    {
        $kabkota = new KabKotaService();

        $kabkotaList = $kabkota->findByProvinsiId($request->provinsi_id);
        return view('formasi.pemetaan_formasi_kabkota', compact(
            'kabkotaList'
        ));
    }

    public function pemetaanFormasiUnitKerja(Request $request)
    {
        $unitKerja = new UnitKerjaService();
        if ($request->wilayah === "provinsi") {
            $unitKerjaList = $unitKerja->findByProvinsiId($request->pro_kab_kota_id);
        } else if ($request->wilayah === "kabupaten") {
            $unitKerjaList = $unitKerja->findByKabupatenId($request->pro_kab_kota_id);
        } else if ($request->wilayah === "kota") {
            $unitKerjaList = $unitKerja->findByKotaId($request->pro_kab_kota_id);
        }

        return view('formasi.pemetaan_formasi_unitkerja', compact(
            'unitKerjaList'
        ));
    }

    public function formasiUnitKerja()
    {
        $userContext = auth()->user();

        dd($userContext);
        $formasiList = $this->formasi->findByUnitKerjaIdAndTaskStatus($userContext->unitKerja->id, TaskStatus::APPROVE);
        $formasiListInactive =  $this->formasi->findByUnitKerjaIdAndTaskStatusAndInactiveFlag($userContext->unitKerja->id, TaskStatus::PENDING, true);
        return view('formasi.jabatan.index', compact(
            'formasiList',
            'formasiListInactive'
        ));
    }

    public function pendaftaranFormasi()
    {
        $userContext = auth()->user();

        $formasi = new FormasiService();
        $formasiDocument = new FormasiDocumentService();
        $formasiList = $formasi->findByUnitKerjaIdAll($userContext->unit_kerja_id);
        $formasiPeneraMessage = null;
        $formasiPengamatTeraMessage = null;
        $formasiPengawasKemetrologianMessage = null;
        $formasiPengujiMutuBarangMessage = null;
        $formasiPengawasPerdaganganMessage = null;
        $formasiAnalisPerdaganganMessage = null;
        if ($formasiList) {
            foreach ($formasiList as $key => $value) {
                $timeline = $value->auditTimeline;
                $counts = count($timeline) ?? 0;
                if ($counts > 0) {
                    switch ($value->jabatan_code) {
                        case 'penera':
                            $formasiPeneraMessage = $timeline[$counts - 1]->description;
                            break;
                        case 'pengamat_tera':
                            $formasiPengamatTeraMessage = $timeline[$counts - 1]->description;
                            break;
                        case 'pengawas_kemetrologian':
                            $formasiPengawasKemetrologianMessage = $timeline[$counts - 1]->description;
                            break;
                        case 'penguji_mutu_barang':
                            $formasiPengujiMutuBarangMessage = $timeline[$counts - 1]->description;
                            break;
                        case 'pengawas_perdagangan':
                            $formasiPengawasPerdaganganMessage = $timeline[$counts - 1]->description;
                            break;
                        case 'analis_perdagangan':
                            $formasiAnalisPerdaganganMessage = $timeline[$counts - 1]->description;
                            break;
                    }
                }
            }
        }
        $systemConfiguration = SystemConfiguration::find("file_persyaratan_formasi");
        $filePersyaratan = $systemConfiguration->property['pendaftaran'];
        $formasiDocument = $formasiDocument->findByUnitKerjaIdAndInactiveFlag($userContext->unit_kerja_id, false);

        return view('formasi.pendaftaran_formasi', compact(
            'formasiPeneraMessage',
            'formasiPengamatTeraMessage',
            'formasiPengawasKemetrologianMessage',
            'formasiPengujiMutuBarangMessage',
            'formasiPengawasPerdaganganMessage',
            'formasiAnalisPerdaganganMessage',
            'filePersyaratan',
            'formasiDocument',
        ));
    }

    public function prosesVerifikasiDokumenOpd()
    {
        $userContext = auth()->user();
        $formasiDocument = new FormasiDocumentService();
        $formasiDocumentList = $formasiDocument->findByUnitKerjaId($userContext->unit_kerja_id);

        return view('formasi.proses_verifikasi_dokumen_opd', compact(
            'formasiDocumentList'
        ));
    }

    public function formasiJabatan($jabatan_code)
    {
        $userContext = auth()->user();
        $formasi = new FormasiService();
        $formasiDocument = new FormasiDocumentService();
        $formasiDocument = $formasiDocument->findByUnitKerjaIdAndInactiveFlag($userContext->unit_kerja_id, false);
        if (!$formasiDocument) {
            session()->flash('response', [
                'title' => 'Error',
                'message' => "Dokumen Persyaratan Belum terpenuhi",
                'icon' => 'error',
            ]);
            return redirect()->route('/formasi/pendaftaran_formasi');
        }

        $formasi = $formasi->findActiveRequest($userContext->unit_kerja_id, $jabatan_code);
        return view('formasi.jabatan.pengajuan', compact(
            'formasi',
            'jabatan_code',
        ));
    }

    public function requestFormasi(Request $request)
    {
        $unitkerja = new UnitKerjaService();

        $data = $request->all();
        $data['attr']['formasiDokumen']['task_status'] = TaskStatus::PENDING;
        $data['attr']['formasiDokumen']['inactive_flag'] = false;
        $data['cond']['formasiDokumen']['task_status'] = '=';
        $data['cond']['formasiDokumen']['inactive_flag'] = '=';
        $data['cond']['id'] = '=';
        $unitKerjaList = $unitkerja->findSearchPaginate($data);
        // $unitKerjaList = $unitkerja->findByFormasiTaskStatusNot(TaskStatus::APPROVE);

        return view('formasi.request_formasi', compact('unitKerjaList'));
    }

    public function requestFormasiDetail(Request $request)
    {
        $unitKerja = new UnitKerjaService();
        $formasiDokument = new FormasiDocumentService();
        $unitKerja = $unitKerja->findById($request->id);
        $formasiList = $this->formasi->findAllPendingByUnitKerjaId($unitKerja->id);
        $formasiDokument = $formasiDokument->findByUnitKerjaIdAndInactiveFlag($unitKerja->id, false);

        if ($formasiDokument->task_status != TaskStatus::PENDING) {
            throw new BusinessException([
                "message" => "Tidak Dapat Mengakses Menu Ini",
                "error code" => "XXX-00000",
                "code" => 500
            ], 500);
        }

        return view('formasi.request_formasi_detail', compact(
            'unitKerja',
            'formasiList',
            'formasiDokument'
        ));
    }

    public function requestFormasiDetailFormasi(Request $request)
    {
        $formasi = new FormasiService();
        $formasi = $formasi->findById($request->id);
        // return view('formasi.task.detail', compact('id'));
        return view('formasi.verifikasi_formasi', compact(
            'formasi',
        ));
    }

    public function requestFormasiDetailVolume(Request $request)
    {
        $formasi = new FormasiService();
        $formasiUnsur = new FormasiUnsurService();

        $formasi = $formasi->findById($request->id);
        $formasiUnsurList = $formasiUnsur->findAllParent($formasi->jabatan_code);
        // return view('formasi.task.detail', compact('id'));
        return view('formasi.verifikasi_formasi_volume', compact(
            'formasi',
            'formasiUnsurList',
        ));
    }

    public function admin_index()
    {
        $unitKerja = new UnitKerjaService();
        $formasi = new FormasiService();

        $formasiList = $formasi->findPendingByUnitKerjaId($unitKerja->id);
        $untiKerjaList = $unitKerja->findAll();
        return view('formasi.admin.index', compact('untiKerjaList', 'formasiList'));
    }

    public function admin_formasi($unit_kerja_id)
    {
        $unitKerja = new UnitKerjaService();
        $formasi = new FormasiService();

        $unitKerja = $unitKerja->findById($unit_kerja_id);
        $formasiList = $formasi->findByUnitKerjaIdAndTaskStatus($unitKerja->id, TaskStatus::APPROVE);
        return view('formasi.admin.formasi', compact('unitKerja', 'formasiList'));
    }

    public function verifikasi_pertama()
    {
        $userContext = auth()->user();

        $formasi = new FormasiService();
        $formasiPenera = $formasi->findByUnitKerjaIdAndJabatanCode($userContext->unit_kerja_id, 'penera') ?? null;
        $formasiAndag = $formasi->findByUnitKerjaIdAndJabatanCode($userContext->unit_kerja_id, 'analis_perdagangan') ?? null;
        $formasiPengTera = $formasi->findByUnitKerjaIdAndJabatanCode($userContext->unit_kerja_id, 'pengamat_tera') ?? null;
        $formasiPengMetro = $formasi->findByUnitKerjaIdAndJabatanCode($userContext->unit_kerja_id, 'pengawas_kemetrologian') ?? null;
        $formasiPenDag = $formasi->findByUnitKerjaIdAndJabatanCode($userContext->unit_kerja_id, 'pengawas_perdagangan') ?? null;
        $formasiPMB = $formasi->findByUnitKerjaIdAndJabatanCode($userContext->unit_kerja_id, 'penguji_mutu_barang') ?? null;
        return view('verifikasi.formasi.index', compact(
            'formasiPenera',
            'formasiPenera',
            'formasiAndag',
            'formasiPengTera',
            'formasiPengMetro',
            'formasiPenDag',
            'formasiPMB',
        ));
    }

    public function verifikasi_pertama_create(Request $request)
    {
        $userContext = auth()->user();

        $formasi = new FormasiService();
        $formasiList = $formasi->findByUnitKerjaIdAndTaskStatus($userContext->unit_kerja_id, TaskStatus::PENDING);

        DB::transaction(function () use ($formasiList, $request) {
            foreach ($formasiList as $key => $value) {
                $value->task_status = $request['task_status'];
                $value->customUpdate();
            }
        });

        return redirect()->route('formasi.verifikasi.pertama');
    }

    public function import()
    {
        return view('import.formasi');
    }

    public function import_create(Request $request)
    {
        $request->validate([
            'file_formasi' => 'required|mimes:csv',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Excel::import(new FormasiImport, $request->file('file_formasi'));
            });
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return redirect()->route('/formasi/data_rekomendasi_formasi');
    }

    public function download_template()
    {
        $data = [['unit kerja/opd id', 'nama unit kerja/opd', 'jabatan', 'total', 'pemula', 'terampil', 'mahir', 'penyelia', 'pertama', 'muda', 'madya', 'utama']];

        $unitKerja = new UnitKerjaService();
        $formasi = new FormasiService();
        $unitKerjaList = $unitKerja->findAll();

        $filename = 'csv/template_formasi.csv';
        $filepath = storage_path('app/' . $filename);

        if (file_exists($filepath)) {
            File::delete($filepath);
        }

        $file = fopen($filepath, 'w');

        foreach ($unitKerjaList as $index => $unitKerja) {
            // Your existing logic for populating $data
            $formasiPenera = $formasi->findByUnitKerjaIdAndJabatanCode($unitKerja->id, 'penera');
            if (!$formasiPenera) {
                $data[] = [$unitKerja->id, $unitKerja->name, 'penera', 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }

            $formasiPenera = $formasi->findByUnitKerjaIdAndJabatanCode($unitKerja->id, 'pengamat_tera');
            if (!$formasiPenera) {
                $data[] = [$unitKerja->id, $unitKerja->name, 'pengamat_tera', 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }

            $formasiPenera = $formasi->findByUnitKerjaIdAndJabatanCode($unitKerja->id, 'pengawas_kemetrologian');
            if (!$formasiPenera) {
                $data[] = [$unitKerja->id, $unitKerja->name, 'pengawas_kemetrologian', 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }

            $formasiPenera = $formasi->findByUnitKerjaIdAndJabatanCode($unitKerja->id, 'penguji_mutu_barang');
            if (!$formasiPenera) {
                $data[] = [$unitKerja->id, $unitKerja->name, 'penguji_mutu_barang', 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }

            $formasiPenera = $formasi->findByUnitKerjaIdAndJabatanCode($unitKerja->id, 'pengawas_perdagangan');
            if (!$formasiPenera) {
                $data[] = [$unitKerja->id, $unitKerja->name, 'pengawas_perdagangan', 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }

            $formasiPenera = $formasi->findByUnitKerjaIdAndJabatanCode($unitKerja->id, 'analis_perdagangan');
            if (!$formasiPenera) {
                $data[] = [$unitKerja->id, $unitKerja->name, 'analis_perdagangan', 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }

            // Write data to the CSV file

        }
        // dd($data);
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        // Close the file stream
        fclose($file);

        // Return the CSV file as a download
        return Storage::download($filename);
    }

    public function konfirmasi(Request $request)
    {
        $this->formasi = $this->formasi->findById($request->id);

        if ($request->task_status === TaskStatus::APPROVE) {
            $this->formasi->inactive_flag = false;
            $this->formasi->task_status = TaskStatus::APPROVE;
            $this->formasi->customUpdate();
        } else if ($request->task_status === TaskStatus::REJECT) {
            $this->formasi->inactive_flag = true;
            $this->formasi->task_status = TaskStatus::REJECT;
            $this->formasi->customDelete();
        }

        return redirect()->back();
    }

    public function uploadRekomendasi(Request $request)
    {
        $unitKerja = new UnitKerjaService();
        $formasi = new FormasiService();

        $unitKerja = $unitKerja->findById($request->unit_kerja_id);
        $formasiList = $formasi->findAllByUnitKerjaIdAndRekomendasiFlag($request->unit_kerja_id);

        return view('formasi.data_rekomendasi', compact(
            'unitKerja',
            'formasiList'
        ));
    }

    public function uploadRekomendasiStore(Request $request)
    {
        $request->validate(['file_rekomendasi_formasi' => 'required']);

        DB::transaction(function () use ($request) {
            $unitKerja = new UnitKerjaService();
            $unitKerja = $unitKerja->findById($request->unit_kerja_id);

            $file = $request['file_rekomendasi_formasi'];
            $rekomendasiFormasi = $this->generateFileName([$unitKerja->id, "rekomendasi_formasi", now()], $file);

            $formasiDokumen = $unitKerja->formasiDokumen;
            if ($formasiDokumen->task_status === TaskStatus::APPROVE) {
                $formasiDokumen->inactive_flag = true;
                $formasiDokumen->save();
            }

            $unitKerja->file_rekomendasi_formasi = $rekomendasiFormasi["bucket_file_name"];
            $unitKerja->customUpdate();

            AuditTimeline::create([
                'association' => 'tbl_formasi_dokumen',
                'association_key' => $formasiDokumen->id,
                'description' => 'penerbitan surat rekomendasi'
            ]);

            MaintenanceStorage::create([
                'association' => 'tbl_unit_kerja',
                'association_key' => $unitKerja->id,
                'file' => $rekomendasiFormasi["bucket_file_name"],
                'task_status' => TaskStatus::APPROVE,
                'name' => 'Rekomendasi Formasi'
            ]);

            $storage = new LocalStorageService();
            $storage->putObject('formasi', $rekomendasiFormasi["file_name"], $file);
        });

        return redirect()->back();
    }

    public function prosesVerifikasiDokumen(Request $request)
    {
        $formasi = new FormasiService();
        $formasi = $formasi->findById($request->id);

        return view('formasi.proses_verifikasi_dokumen', compact(
            'formasi',
        ));
    }

    public function prosesVerifikasiStore(Request $request)
    {
        $validation = ['storage' => 'required'];
        $formasiDocument = new FormasiDocumentService();
        $formasiDocument = $formasiDocument->findById($request->id);

        return DB::transaction(function () use ($request, $validation, $formasiDocument) {
            if ($request->task_status == TaskStatus::REJECT) {
                $request->validate($validation);

                $formasiDocument->task_status = TaskStatus::REJECT;
                $formasiDocument->customSave();

                foreach ($request['storage'] as $id => $value) {
                    $storage = new StorageService();
                    $storage = $storage->findById((int)$id);
                    $storage->task_status = $value;
                    $storage->customSave();
                }

                AuditTimeline::create([
                    'association' => 'tbl_formasi_dokumen',
                    'association_key' => $formasiDocument->id,
                    'description' => 'Dokumen Formasi Ditolak'
                ]);

                return redirect()->route('/formasi/request_formasi');
            } else if ($request->task_status == TaskStatus::APPROVE) {
                $validation['waktu_pelaksanaan'] = 'required';
                $validation['file_surat_undangan'] = 'required|mimes:pdf|max:2048';
                $request->validate($validation);

                $userContext = auth()->user();
                $data = $request->all();

                foreach ($request['storage'] as $id => $value) {
                    if ($value != TaskStatus::APPROVE) {
                        throw new BusinessException([
                            "message" => "Permintaan tidak dapat diterima",
                            "error code" => "FOR-00010",
                            "code" => 500
                        ], 500);
                    } else {
                        $storage = new StorageService();
                        $storage = $storage->findById((int)$id);
                        $storage->task_status = $value;
                        $storage->customSave();
                    }
                }

                $suratUndangan = $this->generateFileName([$userContext->nip, 'surat_undangan', now()], $data['file_surat_undangan']);
                $formasiDocument->file_surat_undangan = $suratUndangan['bucket_file_name'];
                $formasiDocument->waktu_pelaksanaan = $data['waktu_pelaksanaan'];
                $formasiDocument->customSave();

                AuditTimeline::create([
                    'association' => 'tbl_formasi_dokumen',
                    'association_key' => $formasiDocument->id,
                    'description' => 'Verifikasi dokumen',
                    'created_at' => $data['waktu_pelaksanaan'],
                ]);

                $storage = new LocalStorageService();
                $storage->putObject("formasi", $suratUndangan['file_name'], $data['file_surat_undangan']);

                return redirect()->back();
            } else {
                throw new BusinessException([
                    "message" => "Permintaan tidak dapat diterima",
                    "error code" => "FOR-00010",
                    "code" => 500
                ], 500);
            }
        });
    }

    private function generateFileName(array $cr, UploadedFile $file)
    {
        $file_name = '';
        foreach ($cr as $key => $value) {
            if ($file_name === '')
                $file_name = $file_name . $value;
            else
                $file_name = $file_name . '_' . $value;
        }

        $file_name = $file_name . '.' . $file->getClientOriginalExtension();
        $file_name = str_replace('-', '', str_replace(':', '', str_replace(' ', '', $file_name)));
        return [
            'file_name' => $file_name,
            'bucket_file_name' => "formasi" . '/' . $file_name,
        ];
    }

    public function uploadDokumen(Request $request)
    {
        $userContext = auth()->user();
        $validation = [];
        $systemConfiguration = SystemConfiguration::find("file_persyaratan_formasi");
        $filePersyaratan = $systemConfiguration->property['pendaftaran'];
        foreach ($filePersyaratan['values'] as $key => $value) {
            $validation[str_replace(' ', '_', strtolower($value))] = 'required|mimes:pdf|max:2048';
        }
        $request->validate($validation);

        DB::transaction(function () use ($request, $userContext, $filePersyaratan) {
            $unitKerja = $userContext->unitKerja;
            $request['nip'] = $userContext->nip;
            $formasiDokumen = new FormasiDokumen();
            $formasiDokumen->created_by = $userContext->nip ?? null;
            $formasiDokumen->unit_kerja_id = $unitKerja->id;
            $formasiDokumen->inactive_flag = false;
            $formasiDokumen->task_status = TaskStatus::PENDING;
            $formasiDokumen->save();

            $storageService = new StorageService();
            $storageService->customSaveWithUpload($request->all(), $filePersyaratan['values'], 'formasi', 'tbl_formasi_dokumen', $formasiDokumen->id);
        });

        return redirect()->back();
    }

    public function verifiaksiFormasi(Request $request)
    {
        $formasiDocument = new FormasiDocumentService();
        $formasiDocument = $formasiDocument->findById($request->id);

        $validation = [];
        foreach ($formasiDocument->formasi as $key => $formasi) {
            foreach ($formasi->formasiResult as $key => $value) {
                $validation[$value->jenjang_code] = 'required';
            }
        }
        $request->validate($validation);

        DB::transaction(function () use ($request, $formasiDocument) {
            $userContext = auth()->user();
            foreach ($formasiDocument->formasi as $key => $formasiValue) {
                $totalResult = 0;
                foreach ($formasiValue->formasiResult as $key => $formasiResultValue) {
                    $result = $request[$formasiResultValue->jenjang_code];
                    $totalResult = $totalResult + $result;

                    $formasiResultValue->result = $result;
                    $formasiResultValue->updated_by = $userContext->nip;
                    $formasiResultValue->save();
                }
                $formasi = new FormasiService();
                $formasi = $formasi->findById($formasiValue->id);
                $formasi->updateAllInactiveExceptId($formasi->unit_kerja_id, $formasi->jabatan_code, $formasi->id);

                $formasi->total_result = $totalResult;
                $formasi->task_status = TaskStatus::APPROVE;
                $formasi->inactive_flag = false;
                $formasi->customUpdate();
            }

            AuditTimeline::create([
                'association' => 'tbl_formasi_dokumen',
                'association_key' => $formasiDocument->id,
                'description' => 'Penerbitan surat rekomendasi'
            ]);

            $formasiDocument->inactive_flag = false;
            $formasiDocument->task_status = TaskStatus::APPROVE;
            $formasiDocument->customUpdate();
        });

        return redirect()->route('/formasi/request_formasi');
    }

    public function detailDokumen()
    {
        $userContext = auth()->user();
        $formasiDocument = new FormasiDocumentService();
        $formasiDocument = $formasiDocument->findByUnitKerjaIdAndInactiveFlag($userContext->unit_kerja_id, false);

        if (!$formasiDocument) {
            throw new BusinessException([
                "message" => "Dokumen Belum Ada",
                "error code" => "FOR-00020",
                "code" => 500
            ], 500);
        } else if ($formasiDocument->waktu_pelaksanaan) {

            throw new BusinessException([
                "message" => "Dokumen Tidak Dapat Di Update Kembali",
                "error code" => "FOR-00021",
                "code" => 500
            ], 500);
        }

        return view('formasi.formasi_update_dokumen', compact('formasiDocument'));
    }

    public function updateFormasiDocument(Request $request)
    {
        $formasiDocument = new FormasiDocumentService();
        $formasiDocument = $formasiDocument->findById($request->id);

        $validation = [];
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'file')) {
                $validation[$key] = 'required|mimes:pdf|max:2048';
            }
        }
        $request->validate($validation);

        DB::transaction(function () use ($request, $formasiDocument) {
            $storageService = new StorageService();
            $storageService->customUpdateWithUpload($request->all(), 'formasi', 'tbl_formasi_dokumen', $formasiDocument);

            $formasiDocument->task_status = TaskStatus::PENDING;
            $formasiDocument->customUpdate();

            AuditTimeline::create([
                'association' => 'tbl_formasi_dokumen',
                'association_key' => $formasiDocument->id,
                'description' => 'Menunggu Hasil Perbaikan Dokumen'
            ]);
        });

        return redirect()->back();
    }

    public function exportFormasi(Request $request)
    {
        return Excel::download(new UnitKerjaFormasiExport($request->unit_kerja_id), 'rekomendasi_formasi.csv');
    }
}
