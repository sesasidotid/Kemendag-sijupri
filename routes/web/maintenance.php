<?php

use App\Http\Controllers\Maintenance\JabatanController;
use App\Http\Controllers\Maintenance\JenjangController;
use App\Http\Controllers\Maintenance\KabKotaController;
use App\Http\Controllers\Maintenance\PangkatController;
use App\Http\Controllers\Maintenance\PendidikanController;
use App\Http\Controllers\Maintenance\ProvinsiController;
use App\Http\Controllers\Maintenance\SistemConfigurationController;
use App\Http\Controllers\Maintenance\WilayahController;
use App\Http\Controllers\Siap\UnitKerjaController;
use Illuminate\Support\Facades\Route;

Route::get('/maintenance/pendidikan', [PendidikanController::class, 'index'])
        ->name('/maintenance/pendidikan');

    Route::get('/maintenance/jabatan', [JabatanController::class, 'index'])
        ->name('/maintenance/jabatan');

    Route::get('/maintenance/jenjang', [JenjangController::class, 'index'])
        ->name('/maintenance/jenjang');

    Route::get('/maintenance/pangkat', [PangkatController::class, 'index'])
        ->name('/maintenance/pangkat');

    Route::get('/maintenance/wilayah', [WilayahController::class, 'index'])
        ->name('/maintenance/wilayah');

    Route::get('/maintenance/provinsi', [ProvinsiController::class, 'index'])
        ->name('/maintenance/provinsi');
    Route::get('/maintenance/provinsi/{id}', [ProvinsiController::class, 'detail'])
        ->name('/maintenance/provinsi/detail');

    Route::post('/maintenance/provinsi/store', [ProvinsiController::class, 'store'])
        ->name('/maintenance/provinsi/store')
        ->defaults('object', 'Provinsi');
    Route::put('/maintenance/provinsi/update', [ProvinsiController::class, 'update'])
        ->name('/maintenance/provinsi/update')
        ->defaults('object', 'Provinsi');
    Route::delete('/maintenance/provinsi/delete', [ProvinsiController::class, 'delete'])
        ->name('/maintenance/provinsi/delete')
        ->defaults('object', 'Provinsi');

    Route::get('/maintenance/kabupaten', [KabKotaController::class, 'kabupaten'])
        ->name('/maintenance/kabupaten');
    Route::get('/maintenance/kabupaten/{id}', [KabKotaController::class, 'detailKabupaten'])
        ->name('/maintenance/kabupaten/detail');

    Route::post('/maintenance/kabupaten/store', [KabKotaController::class, 'storeKabupaten'])
        ->name('/maintenance/kabupaten/store')
        ->defaults('object', 'Kabupaten');
    Route::put('/maintenance/kabupaten/update', [KabKotaController::class, 'updateKabupaten'])
        ->name('/maintenance/kabupaten/update')
        ->defaults('object', 'Kabupaten');
    Route::delete('/maintenance/kabupaten/delete', [KabKotaController::class, 'delete'])
        ->name('/maintenance/kabupaten/delete')
        ->defaults('object', 'Kabupaten');

    Route::get('/maintenance/kota', [KabKotaController::class, 'kota'])
        ->name('/maintenance/kota');
    Route::get('/maintenance/kota/{id}', [KabKotaController::class, 'detailKota'])
        ->name('/maintenance/kota/detail');

    Route::post('/maintenance/kota/store', [KabKotaController::class, 'storeKota'])
        ->name('/maintenance/kota/store')
        ->defaults('object', 'Kota');
    Route::put('/maintenance/kota/update', [KabKotaController::class, 'updateKota'])
        ->name('/maintenance/kota/update')
        ->defaults('object', 'Kota');
    Route::delete('/maintenance/kota/delete', [KabKotaController::class, 'delete'])
        ->name('/maintenance/kota/delete')
        ->defaults('object', 'Kota');

    Route::get('/maintenance/unit_kerja_instansi_daerah', [UnitKerjaController::class, 'index'])
        ->name('/maintenance/unit_kerja_instansi_daerah');
    Route::get('/maintenance/unit_kerja_instansi_daerah/create', [UnitKerjaController::class, 'create'])
        ->name('/maintenance/unit_kerja_instansi_daerah/create');
    Route::get('/maintenance/unit_kerja_instansi_daerah/{id}', [UnitKerjaController::class, 'detail'])
        ->name('/maintenance/unit_kerja_instansi_daerah/detail');
    Route::get('/maintenance/unit_kerja_instansi_daerah/sijupri/{id}', [UnitKerjaController::class, 'detailSijupri'])
        ->name('/maintenance/unit_kerja_instansi_daerah/sijupri/detail');

    Route::post('/maintenance/unit_kerja_instansi_daerah/store', [UnitKerjaController::class, 'store'])
        ->name('/maintenance/unit_kerja_instansi_daerah/store')
        ->defaults('object', 'Unit Kerja/Instansi Daerah');
    Route::put('/maintenance/unit_kerja_instansi_daerah/update', [UnitKerjaController::class, 'update'])
        ->name('/maintenance/unit_kerja_instansi_daerah/update')
        ->defaults('object', 'Unit Kerja/Instansi Daerah');
    Route::put('/maintenance/unit_kerja_instansi_daerah/update_sijupri', [UnitKerjaController::class, 'updateSijupri'])
        ->name('/maintenance/unit_kerja_instansi_daerah/update_sijupri')
        ->defaults('object', 'Unit Kerja/Instansi Daerah');
    Route::delete('/maintenance/unit_kerja_instansi_daerah/delete', [UnitKerjaController::class, 'delete'])
        ->name('/maintenance/unit_kerja_instansi_daerah/delete')
        ->defaults('object', 'Unit Kerja/Instansi Daerah');

    Route::get('/maintenance/konfigurasi', [SistemConfigurationController::class, 'index'])
        ->name('/maintenance/konfigurasi');
    Route::get('/maintenance/konfigurasi/{code}', [SistemConfigurationController::class, 'detail'])
        ->name('/maintenance/konfigurasi/detail');

    Route::put('/maintenance/konfigurasi/edit', [SistemConfigurationController::class, 'edit'])
        ->name('/maintenance/konfigurasi/edit')
        ->defaults('object', 'Sistem Konfigurasi');
