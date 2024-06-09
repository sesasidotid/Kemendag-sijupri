<?php

use App\Http\Controllers\Formasi\FormasiController;
use App\Http\Controllers\Formasi\Service\FormasiService;
use Illuminate\Support\Facades\Route;

Route::get('/formasi/pendaftaran_formasi', [FormasiController::class, "pendaftaranFormasi"])
    ->name('/formasi/pendaftaran_formasi');
Route::get('/formasi/pendaftaran_formasi/detail_dokumen', [FormasiController::class, "detailDokumen"])
    ->name('/formasi/pendaftaran_formasi/detail_dokumen');
Route::put('/formasi/pendaftaran_formasi/detail_dokumen', [FormasiController::class, "updateFormasiDocument"])
    ->name('/formasi/pendaftaran_formasi/update')
    ->defaults('object', 'Ubah Parameter Dokumen Formasi');
Route::get('/formasi/pendaftaran_formasi/{jabatan_code}', [FormasiController::class, "formasiJabatan"])
    ->name('/formasi/pendaftaran_formasi/detail');
Route::post('/formasi/upload_dokumen', [FormasiController::class, "uploadDokumen"])
    ->name('/formasi/upload_dokumen')
    ->defaults('object', 'Upload Dokumen Formasi');
Route::get('/formasi/proses_verifikasi_dokumen', [FormasiController::class, "prosesVerifikasiDokumenOpd"])
    ->name('/formasi/proses_verifikasi_dokumen');


Route::get('/formasi/jabatan', [FormasiController::class, "formasiUnitKerja"])
    ->name('/formasi/jabatan');
Route::post('/formasi/jabatan/konfirmasi', [FormasiController::class, "konfirmasi"])
    ->name('/formasi/jabatan/konfirmasi')
    ->defaults('object', 'Konfirmasi Formasi');

Route::get('/formasi/jabatan/{jabatan_code}', [FormasiController::class, "formasiJabatan"])
    ->name('/formasi/jabatan/detail');

Route::get('/formasi/verifikasi', [FormasiController::class, "verifikasi_pertama"])
    ->name('/formasi/verifikasi/pertama');

Route::post('/formasi/verifikasi/create', [FormasiController::class, "verifikasi_pertama_create"])
    ->name('/formasi/verifikasi/create')
    ->defaults('object', 'Formasi Pertama');

Route::get('/formasi/pemetaan_formasi_seluruh_indonesia', [FormasiController::class, "pemetaanFormasi"])
    ->name('/formasi/pemetaan_formasi_seluruh_indonesia');
Route::get('/formasi/pemetaan_formasi_seluruh_indonesia/kabkota/{provinsi_id}', [FormasiController::class, "pemetaanFormasiKabKota"])
    ->name('/formasi/pemetaan_formasi_seluruh_indonesia/kabkota');
Route::get('/formasi/pemetaan_formasi_seluruh_indonesia/unit_kerja/{wilayah}/{pro_kab_kota_id}', [FormasiController::class, "pemetaanFormasiUnitKerja"])
    ->name('/formasi/pemetaan_formasi_seluruh_indonesia/unit_kerja');

Route::get('/formasi/import', [FormasiController::class, "import"])
    ->name('/formasi/import');
Route::post('/formasi/import', [FormasiController::class, "import_create"])
    ->name('/formasi/import/create')
    ->defaults('object', 'Import Formasi');
Route::post('/formasi/import/template', [FormasiController::class, "download_template"])
    ->name('/formasi/import/template')
    ->defaults('object', 'Download Template Formasi');

Route::get('/formasi/data_rekomendasi_formasi', [FormasiController::class, "index"])
    ->name('/formasi/data_rekomendasi_formasi');
Route::get('/formasi/data_rekomendasi_formasi/detail/{id}', [FormasiController::class, 'dataRekomendasiFormasiDetail'])
    ->name('/formasi/data_rekomendasi_formasi/detail');
Route::get('/formasi/data_rekomendasi_formasi/detail_formasi/{id}', [FormasiController::class, 'dataRekomendasiFormasiDetailFormasi'])
    ->name('/formasi/data_rekomendasi_formasi/detail_formasi');
Route::get('/formasi/data_rekomendasi_formasi/riwayat_rekomendasi', [FormasiController::class, "riwayatRekomendasi"])
    ->name('/formasi/data_rekomendasi_formasi/riwayat_rekomendasi');

Route::get('/formasi/data_rekomendasi_formasi/export_formasi/{unit_kerja_id}', [FormasiController::class, 'exportFormasi'])
    ->name('/formasi/data_rekomendasi_formasi/export_formasi');
Route::get('/formasi/data_rekomendasi_formasi/upload_rekomendasi/{unit_kerja_id}', [FormasiController::class, 'uploadRekomendasi'])
    ->name('/formasi/data_rekomendasi_formasi/upload_rekomendasi');
Route::post('/formasi/data_rekomendasi_formasi/upload_rekomendasi/store', [FormasiController::class, 'uploadRekomendasiStore'])
    ->name('/formasi/data_rekomendasi_formasi/upload_rekomendasi/store')
    ->defaults('object', 'Upload Rekomendasi Formasi');

Route::get('/formasi/request_formasi', [FormasiController::class, "requestFormasi"])
    ->name('/formasi/request_formasi');
Route::get('/formasi/request_formasi/detail/{id}', [FormasiController::class, "requestFormasiDetail"])
    ->name('/formasi/request_formasi/detail');
Route::get('/formasi/request_formasi/detail_formasi/{id}', [FormasiController::class, "requestFormasiDetailFormasi"])
    ->name('/formasi/request_formasi/detail_formasi');
Route::get('/formasi/request_formasi/detail_volumen/{id}', [FormasiController::class, "requestFormasiDetailVolume"])
    ->name('/formasi/request_formasi/detail_volumen');
Route::post('/formasi/request_formasi/verifikasi', [FormasiController::class, "verifiaksiFormasi"])
    ->name('/formasi/request_formasi/verifikasi')
    ->defaults('object', 'Verifikasi Formasi');

Route::get('/formasi/request_formasi/proses_verifikasi_dokumen/{id}', [FormasiController::class, "prosesVerifikasiDokumen"])
    ->name('/formasi/request_formasi/proses_verifikasi_dokumen');
Route::post('/formasi/request_formasi/proses_verifikasi_dokumen/store', [FormasiController::class, "prosesVerifikasiStore"])
    ->name('/formasi/request_formasi/proses_verifikasi_dokumen/store')
    ->defaults('object', 'Tambah Dokumen Pelaksanaan');


Route::get('/formasi/penera', function () {
    $formasiController = new FormasiController(new FormasiService());
    return $formasiController->formasiJabatan('penera');
})->name('/formasi/penera');
Route::get('/formasi/pengamat_tera', function () {
    $formasiController = new FormasiController(new FormasiService());
    return $formasiController->formasiJabatan('pengamat_tera');
})->name('/formasi/pengamat_tera');
Route::get('/formasi/pengawas_kemetrologian', function () {
    $formasiController = new FormasiController(new FormasiService());
    return $formasiController->formasiJabatan('pengawas_kemetrologian');
})->name('/formasi/pengawas_kemetrologian');
Route::get('/formasi/penguji_mutu_barang', function () {
    $formasiController = new FormasiController(new FormasiService());
    return $formasiController->formasiJabatan('penguji_mutu_barang');
})->name('/formasi/penguji_mutu_barang');
Route::get('/formasi/pengawas_perdagangan', function () {
    $formasiController = new FormasiController(new FormasiService());
    return $formasiController->formasiJabatan('pengawas_perdagangan');
})->name('/formasi/pengawas_perdagangan');
Route::get('/formasi/analis_perdagangan', function () {
    $formasiController = new FormasiController(new FormasiService());
    return $formasiController->formasiJabatan('analis_perdagangan');
})->name('/formasi/analis_perdagangan');
