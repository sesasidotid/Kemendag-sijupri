<?php

use App\Http\Controllers\AKP\AkpController;
use App\Http\Controllers\AKP\AkpKknController;
use App\Http\Controllers\AKP\AkpMatrixController;
use App\Http\Controllers\AKP\AkpReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['handler.validation_access'])->group(function () {
    Route::get('/akp/review', [AkpReviewController::class, "index"])
        ->name('/akp/review');
    Route::get('/akp/review/personal/{id}', [AkpReviewController::class, "personal"])
        ->name('/akp/review/personal');
    Route::get('/akp/review/rekomendasi/{id}', [AkpReviewController::class, "rekomendasi"])
        ->name('/akp/review/rekomendasi');

    Route::get('/akp/generate_url/atasan', [AkpController::class, "generateUrlAtasan"])
        ->name('/akp/generate_url/atasan');
    Route::get('/akp/generate_url/rekan', [AkpController::class, "generateUrlRekan"])
        ->name('/akp/generate_url/rekan');

    Route::get('/akp/kkn', [AkpKknController::class, "index"])
        ->name('/akp/kkn');
    Route::get('/akp/kkn/{id}', [AkpKknController::class, "detail"])
        ->name('/akp/kkn/detail');
    Route::post('/akp/kkn/store', [AkpKknController::class, "store"])
        ->name('/akp/kkn/store')
        ->defaults('object', 'Kategori AKP');
    Route::put('/akp/kkn/edit', [AkpKknController::class, "edit"])
        ->name('/akp/kkn/edit')
        ->defaults('object', 'Kategori AKP');
    Route::delete('/akp/kkn/delete', [AkpKknController::class, "delete"])
        ->name('/akp/kkn/delete')
        ->defaults('object', 'Kategori AKP');

    Route::get('/akp/kkn/pertanyaan/{akp_kategori_pertanyaan_id}', [AkpKknController::class, "pertanyaan"])
        ->name('/akp/kkn/pertanyaan');
    Route::get('/akp/kkn/pertanyaan/detail/{id}', [AkpKknController::class, "pertanyaanDetail"])
        ->name('/akp/kkn/pertanyaan/detail');
    Route::post('/akp/kkn/pertanyaan/store', [AkpKknController::class, "pertanyaanStore"])
        ->name('/akp/kkn/pertanyaan/store')
        ->defaults('object', 'Pertanyaan AKP');
    Route::put('/akp/kkn/pertanyaan/edit', [AkpKknController::class, "pertanyaanEdit"])
        ->name('/akp/kkn/pertanyaan/edit')
        ->defaults('object', 'Pertanyaan AKP');
    Route::delete('/akp/kkn/pertanyaan/delete', [AkpKknController::class, "pertanyaanDelete"])
        ->name('/akp/kkn/pertanyaan/delete')
        ->defaults('object', 'Pertanyaan AKP');

    Route::get('/akp/daftar', [AkpController::class, "admin_index"])
        ->name('/akp/daftar');
    Route::get('/akp/daftar/{id}', [AkpController::class, "admin_detail"])
        ->name('/akp/daftar/detail');

    Route::put('/akp/edit_matrix', [AkpController::class, "updateAkpMatrix"])
        ->name('/akp/edit_matrix')
        ->defaults('object', 'Matrix Rekomendasi');
    Route::post('/akp/upload_rekomendasi', [AkpController::class, 'uploadRekomendasi'])
        ->name('/akp/upload_rekomendasi')
        ->defaults('object', 'Upload Rekomendasi Akp');

    Route::get('/akp/pemetaan_akp', [AkpController::class, 'userJf'])
        ->name('/akp/pemetaan_akp');

    Route::get('/akp/daftar_user_akp/{nip}', [AkpController::class, 'daftarUserAKP'])
        ->name('/akp/daftar_user_akp');

    Route::post('/akp/daftar/export/{id}', [AkpController::class, 'export'])
        ->name('/akp/daftar/export')
        ->defaults('object', 'Export Hasil AKP');

    Route::post('/akp/matrix/pelatihan', [AkpMatrixController::class, 'updateRekomendasiPelatihan'])
        ->name('/akp/matrix/pelatihan')
        ->defaults('object', 'Matrix Rekomendasi');

    Route::post('/akp/export', [AkpController::class, 'export'])
        ->name('/akp/export')
        ->defaults('object', 'Export Hasil AKP');
});
