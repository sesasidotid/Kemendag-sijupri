<?php

use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Siap\ProfileController;
use App\Http\Controllers\Siap\RegistrationController;
use App\Http\Controllers\Siap\SiapController;
use Illuminate\Support\Facades\Route;

Route::get('/user/admin_instansi', [SiapController::class, "admin_instansi"])
->name('/user/admin_instansi');
Route::get('/user/admin_instansi/detail/{nip}', [SiapController::class, "detail_admin_instansi"])
->name('/user/admin_instansi/detail');
Route::put('/user/admin_instansi/edit/{nip}', [UserController::class, "editInstansi"])
->name('/user/admin_instansi/edit')
->defaults('object', 'Admin Instansi');

Route::get('/user/admin_unit_kerja_instansi_daerah', [SiapController::class, 'admin_pengelola'])
->name('/user/admin_unit_kerja_instansi_daerah');
Route::get('/user/admin_unit_kerja_instansi_daerah/detail/{nip}', [SiapController::class, 'detail_admin_pengelola'])
->name('/user/admin_unit_kerja_instansi_daerah/detail');
Route::put('/user/admin_unit_kerja_instansi_daerah/edit/{nip}', [UserController::class, 'editOpd'])
->name('/user/admin_unit_kerja_instansi_daerah/edit')
->defaults('object', 'Admin Unit Kerja/Instansi Daerah');

Route::get('/user/user_jf', [UserController::class, 'userJF'])
->name('/user/user_jf');
Route::get('/user/user_jf/detail/{nip}', [UserController::class, 'userJfDetail'])
->name('/user/user_jf/detail');
Route::put('/user/user_jf/edit/{nip}', [UserController::class, 'editJf'])
->name('/user/user_jf/edit')
->defaults('object', 'User JF');

Route::put('/user/user_jf/verifikasi/user_detail', [UserController::class, 'verifikasiUserDetail'])
->name('/user/user_jf/verifikasi/user_detail')
->defaults('object', 'Verifikasi User Detail');
Route::put('/user/user_jf/verifikasi/user_pendidikan', [UserController::class, 'verifikasiUserPendidikan'])
->name('/user/user_jf/verifikasi/user_pendidikan')
->defaults('object', 'Verifikasi Riwayat Pendidikan');
Route::put('/user/user_jf/verifikasi/user_jabatan', [UserController::class, 'verifikasiUserJabatan'])
->name('/user/user_jf/verifikasi/user_jabatan')
->defaults('object', 'Verifikasi Riwayat Jabatan');
Route::put('/user/user_jf/verifikasi/user_pangkat', [UserController::class, 'verifikasiUserPangkat'])
->name('/user/user_jf/verifikasi/user_pangkat')
->defaults('object', 'Verifikasi Riwayat Pangkat');
Route::put('/user/user_jf/verifikasi/user_kompetensi', [UserController::class, 'verifikasiUserKompetensi'])
->name('/user/user_jf/verifikasi/user_kompetensi')
->defaults('object', 'Verifikasi Riwayat Kompetensi');
Route::put('/user/user_jf/verifikasi/user_sertifikat', [UserController::class, 'verifikasiUserSertifikasi'])
->name('/user/user_jf/verifikasi/user_sertifikat')
->defaults('object', 'Verifikasi Riwayat Sertifikat');

Route::get('/registration/sijupri', [RegistrationController::class, 'sijupri'])
->name('/registration/sijupri')
->defaults('object', 'Admin SIjuPRI');
Route::get('/registration/instansi', [RegistrationController::class, 'instansi'])
->name('/registration/instansi')
->defaults('object', 'Admin Instansi');
Route::get('/registration/pengelola', [RegistrationController::class, 'pengelola'])
->name('/registration/pengelola')
->defaults('object', 'Admin Unit Kerja/Instansi Daerah');
Route::get('/registration/user', [RegistrationController::class, 'user'])
->name('/registration/user')
->defaults('object', 'User JF');

Route::get('/profile', [ProfileController::class, 'index'])
->name('/profile');
Route::get('/profile/detail', [ProfileController::class, 'detail'])
->name('/profile/detail');

Route::post('/profile/instansi', [ProfileController::class, 'instansi_update'])
->name('/profile/instansi')
->defaults('object', 'Profil Admin Instansi');

Route::post('/profile/unit_kerja_instansi_daerah', [ProfileController::class, 'unitkerjaOpd_update'])
->name('/profile/unit_kerja_instansi_daerah')
->defaults('object', 'Profil Admin Unit Kerja/Instansi Daerah');
