<?php

use App\Http\Controllers\Siap\SiapController;
use Illuminate\Support\Facades\Route;

Route::post('/siap/user_detail/store', [SiapController::class, 'userDetailStore'])
    ->name('/siap/user_detail/store')
    ->defaults('object', 'Ubah User Detail');

Route::get('/siap/pendidikan/detail/{id}', [SiapController::class, 'userPendidikanDetail'])
    ->name('/siap/pendidikan/detail');
Route::post('/siap/pendidikan/store', [SiapController::class, 'userPendidikanStore'])
    ->name('/siap/pendidikan/store')
    ->defaults('object', 'Tambah Riwayat Pendidikan');
Route::put('/siap/pendidikan/update', [SiapController::class, 'userPendidikanStore'])
    ->name('/siap/pendidikan/update')
    ->defaults('object', 'Ubah Riwayat Pendidikan');
Route::delete('/siap/pendidikan/delete/{id}', [SiapController::class, 'userPendidikanDelete'])
    ->name('/siap/pendidikan/delete')
    ->defaults('object', 'Delete Riwayat Pendidikan');

Route::get('/siap/jabatan/detail/{id}', [SiapController::class, 'userJabatanDetail'])
    ->name('/siap/jabatan/detail');
Route::post('/siap/jabatan/store', [SiapController::class, 'userJabatanStore'])
    ->name('/siap/jabatan/store')
    ->defaults('object', 'Tambah Riwayat Jabatan');
Route::put('/siap/jabatan/update', [SiapController::class, 'userJabatanStore'])
    ->name('/siap/jabatan/update')
    ->defaults('object', 'Ubah Riwayat Jabatan');
Route::delete('/siap/jabatan/delete/{id}', [SiapController::class, 'userJabatanDelete'])
    ->name('/siap/jabatan/delete')
    ->defaults('object', 'Delete Riwayat Jabatan');

Route::get('/siap/pangkat/detail/{id}', [SiapController::class, 'userPangkatDetail'])
    ->name('/siap/pangkat/detail');
Route::post('/siap/pangkat/store', [SiapController::class, 'userPangkatStore'])
    ->name('/siap/pangkat/store')
    ->defaults('object', 'Tambah Riwayat Pangkat');
Route::put('/siap/pangkat/update', [SiapController::class, 'userPangkatStore'])
    ->name('/siap/pangkat/update')
    ->defaults('object', 'Ubah Riwayat Pangkat');
Route::delete('/siap/pangkat/delete/{id}', [SiapController::class, 'userPangkatDelete'])
    ->name('/siap/pangkat/delete')
    ->defaults('object', 'Delete Riwayat Pangkat');

Route::get('/siap/kinerja/detail/{id}', [SiapController::class, 'userPakDetail'])
    ->name('/siap/kinerja/detail');
Route::post('/siap/kinerja/store', [SiapController::class, 'userKinerjaStore'])
    ->name('/siap/kinerja/store')
    ->defaults('object', 'Tambah Riwayat Kinerja');
Route::put('/siap/kinerja/update', [SiapController::class, 'userKinerjaStore'])
    ->name('/siap/kinerja/update')
    ->defaults('object', 'Ubah Riwayat Kinerja');
Route::delete('/siap/kinerja/delete/{id}', [SiapController::class, 'userKinerjaDelete'])
    ->name('/siap/kinerja/delete')
    ->defaults('object', 'Delete Riwayat Kinerja');

Route::get('/siap/kompetensi/detail/{id}', [SiapController::class, 'userKompetensiDetail'])
    ->name('/siap/kompetensi/detail');
Route::post('/siap/kompetensi/store', [SiapController::class, 'userKompetensiStore'])
    ->name('/siap/kompetensi/store')
    ->defaults('object', 'Tambah Riwayat Kompetensi');
Route::put('/siap/kompetensi/update', [SiapController::class, 'userKompetensiStore'])
    ->name('/siap/kompetensi/update')
    ->defaults('object', 'Ubah Riwayat Kompetensi');
Route::delete('/siap/kompetensi/delete/{id}', [SiapController::class, 'userKompetensiDelete'])
    ->name('/siap/kompetensi/delete')
    ->defaults('object', 'Delete Riwayat Kompetensi');

Route::get('/siap/sertifikasi/detail/{id}', [SiapController::class, 'userSertifikasiDetail'])
    ->name('/siap/sertifikasi/detail');
Route::post('/siap/sertifikasi/store', [SiapController::class, 'userSertifikasiStore'])
    ->name('/siap/sertifikasi/store')
    ->defaults('object', 'Tambah Riwayat Sertifikasi');
Route::put('/siap/sertifikasi/update', [SiapController::class, 'userSertifikasiStore'])
    ->name('/siap/sertifikasi/update')
    ->defaults('object', 'Ubah Riwayat Sertifikasi');
Route::delete('/siap/sertifikasi/delete/{id}', [SiapController::class, 'userSertifikasiDelete'])
    ->name('/siap/sertifikasi/delete')
    ->defaults('object', 'Delete Riwayat Sertifikasi');
