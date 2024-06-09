<?php

use App\Http\Controllers\PoinAKController;
use Illuminate\Support\Facades\Route;

Route::get('/monitoring_kinerja', [PoinAKController::class, 'tampilSemuaUsers'])
    ->name('/monitoring_kinerja');
Route::get('/monitoring_kinerja/pemetaan_kinerja', [PoinAKController::class, 'pemetaanPAK'])
    ->name('/monitoring_kinerja/pemetaan_kinerja');
Route::get('/monitoring_kinerja/pemetaan_kinerja/detail/{nip}', [PoinAKController::class, 'detailUserpak'])
    ->name('/monitoring_kinerja/pemetaan_kinerja/detail');
Route::put('/monitoring_kinerja/pemetaan_kinerja/detail/edit', [PoinAKController::class, 'verifikasiTaskStatus'])
    ->name('/monitoring_kinerja/pemetaan_kinerja/detail/edit')
    ->defaults('object', 'Verifikasi PAK');
