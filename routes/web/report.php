<?php

use App\Http\Controllers\Report\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/report/download/{id}', [ReportController::class, "downloadReport"])
    ->name('/report/download');
Route::delete('/report/hapus/{id}', [ReportController::class, "deleteReport"])
    ->name('/report/hapus')
    ->defaults('object', 'Hapus Report');

Route::get('/report/rekomendasi_formasi', [ReportController::class, "rekomendasiFormasiView"])
    ->name('/report/rekomendasi_formasi');
Route::post('/report/rekomendasi_formasi', [ReportController::class, "generateRekomendasiFormasi"])
    ->name('/report/rekomendasi_formasi/generate')
    ->defaults('object', 'Generate Report Rekomendasi Formasi');
