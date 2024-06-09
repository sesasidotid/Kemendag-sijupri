<?php

use App\Http\Controllers\Ukom\UkomController;
use App\Http\Controllers\Ukom\UkomPeriodeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['handler.validation_access'])->group(function () {
    Route::get('/ukom/periode', [UkomPeriodeController::class, 'index'])
        ->name('/ukom/periode');
    Route::post('/ukom/periode/store', [UkomPeriodeController::class, 'store'])
        ->name('/ukom/periode/store')
        ->defaults('object', 'Periode Ukom');
    Route::get('/ukom/periode/toggle/{id}', [UkomPeriodeController::class, 'toggleActivation'])
        ->name('/ukom/periode/toggle');
    Route::get('/ukom/periode/detail/{id}', [UkomPeriodeController::class, 'detail'])
        ->name('/ukom/periode/detail');
    Route::put('/ukom/periode/edit', [UkomPeriodeController::class, 'edit'])
        ->name('/ukom/periode/edit')
        ->defaults('object', 'Periode Ukom');
    Route::delete('/ukom/periode/delete/{id}', [UkomPeriodeController::class, 'delete'])
        ->name('/ukom/periode/delete')
        ->defaults('object', 'Periode Ukom');

    Route::get('/ukom/pendaftaran_ukom', [UkomController::class, 'pendaftaranUkom'])
        ->name('/ukom/pendaftaran_ukom');
    Route::put('/ukom/pendaftaran_ukom/perbaikan', [UkomController::class, 'perbaikan'])
        ->name('/ukom/pendaftaran_ukom/perbaikan')
        ->defaults('object', 'Perbaikan Pendaftaran Ukom');

    Route::get('/ukom/kenaikan_jenjang', [UkomController::class, 'kenaikanJenjang'])
        ->name('/ukom/kenaikan_jenjang');
    Route::post('/ukom/kenaikan_jenjang/store', [UkomController::class, 'kenaikanJenjangStore'])
        ->name('/ukom/kenaikan_jenjang/store')
        ->defaults('object', 'Pendaftaran Ukom Kenaikan Jenjang');

    Route::get('/ukom/perpindahan_jabatan', [UkomController::class, 'perpindahanJabatan'])
        ->name('/ukom/perpindahan_jabatan');
    Route::post('/ukom/perpindahan_jabatan/store', [UkomController::class, 'perpindahanJabatanStore'])
        ->name('/ukom/perpindahan_jabatan/store')
        ->defaults('object', 'Pendaftaran Ukom Perpindahan Jabatan');

    Route::get('/ukom/riwayat_ukom', [UkomController::class, 'riwayatUkom'])
        ->name('/ukom/riwayat_ukom');
    Route::get('/ukom/riwayat_ukom/{id}', [UkomController::class, 'riwayatUkomDetail'])
        ->name('/ukom/riwayat_ukom/detail');

    Route::get('/ukom/publish_hasil', [UkomController::class, 'publishHasil'])
        ->name('/ukom/publish_hasil');
    Route::post('/ukom/publish_hasil/store', [UkomController::class, 'publishHasilStore'])
        ->name('/ukom/publish_hasil/store')
        ->defaults('object', 'Publish Hasil Ukom');

    //Ukom --Goldian
    Route::get('/ukom/pendaftaran', [UkomController::class, 'daftarPendaftaran'])
        ->name('/ukom/pendaftaran');
    Route::get('/ukom/pendaftaran/detail/{id}', [UkomController::class, 'daftarPendaftaranDetail'])
        ->name('/ukom/pendaftaran/detail');
    Route::put('/ukom/pendaftaran/approval', [UkomController::class, 'approvalPendaftaran'])
        ->name('/ukom/pendaftaran/approval')
        ->defaults('object', 'Approve Pendaftaran UKom');

    Route::get('/ukom/pemetaan_ukom', [UkomController::class, 'pemetaanUkom'])
        ->name('/ukom/pemetaan_ukom');
    Route::get('/ukom/pemetaan_ukom/{id}', [UkomController::class, 'pemetaanUkomDetail'])
        ->name('/ukom/pemetaan_ukom/detail');
    Route::post('/ukom/upload_rekomendasi', [UkomController::class, 'uploadRekomendasi'])
        ->name('/ukom/upload_rekomendasi')
        ->defaults('object', 'Upload Rekomendasi UKom');

    Route::get('/ukom/import_nilai', [UkomController::class, 'importNilai'])
        ->name('/ukom/import_nilai');
    Route::post('/ukom/import_nilai/template_mansoskul', [UkomController::class, 'importNilaiTemplateMansoskul'])
        ->name('/ukom/import_nilai/template_mansoskul')
        ->defaults('object', 'Download Template Mansoskul');
    Route::post('/ukom/import_nilai/template_teknis', [UkomController::class, 'importNilaiTemplateTeknis'])
        ->name('/ukom/import_nilai/template_teknis')
        ->defaults('object', 'Download Template Teknis');

    Route::post('/ukom/import_nilai/store', [UkomController::class, 'importNilaiStore'])
        ->name('/ukom/import_nilai/store')
        ->defaults('object', 'Import Nilai UKom');
});
