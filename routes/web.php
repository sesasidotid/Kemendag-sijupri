<?php

use App\Http\Controllers\AKP\AkpReviewController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Audit\AuditController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Maintenance\PengumumanController;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use App\Http\Controllers\Security\AuthController;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Service\MessagingService;
use App\Http\Controllers\Siap\DashboardController;
use App\Http\Controllers\Ukom\UkomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['handler.response'])->group(function () {

    Route::get('/testing', function () {
        $provinsi = new ProvinsiService();
        $provinsiList = $provinsi->findAll();

        return view('email-template.ukom_mengulang', compact(
            'provinsiList'
        ));
    });

    //Landing Page
    Route::get('/', [LandingPageController::class, 'index'])->name('/');
    Route::get('/page/ukom/internal', [LandingPageController::class, 'pageUkomInternal'])
        ->name('/page/ukom/internal');
    Route::get('/page/ukom/external', [LandingPageController::class, 'pageUkomExternal'])
        ->name('/page/ukom/external');
    Route::get('/page/ukom/{pendaftaran_code}', [LandingPageController::class, 'pageUkomDetail'])
        ->name('/page/ukom/detail');

    Route::post('/page/ukom/daftar', [UkomController::class, 'daftarUkomNonJF'])
        ->name('/page/ukom/daftar');

    Route::put('/page/ukom/pendaftaran_ukom/perbaikan', [UkomController::class, 'perbaikanNonJF'])
        ->name('/page/ukom/pendaftaran_ukom/perbaikan')
        ->defaults('object', 'Perbaikan Pendaftaran Ukom');

    //auth
    Route::get('/login', [AuthController::class, 'index'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware(['throttle:10,1'])
        ->name('do_login');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
    Route::post('/siap/password', [AuthController::class, 'password_update'])
        ->name('siap.password');

    //AKP
    Route::get('/akp/review/atasan/{nip}', [AkpReviewController::class, "atasan"])
        ->name('/akp/review/atasan');
    Route::get('/akp/review/rekan/{nip}', [AkpReviewController::class, "rekan"])
        ->name('/akp/review/rekan');
    Route::get('/akp/review/selesai', [AkpReviewController::class, 'selesai'])
        ->name('/akp/review/selesai');
    Route::get('/akp/review/failed', [AkpReviewController::class, 'failed'])
        ->name('/akp/review/failed');

    //UKom
    Route::post('/ukom/promosi/store', [UkomController::class, 'promosiStore'])
        ->name('/ukom/promosi/store')
        ->defaults('object', 'Pendaftaran Ukom Promosi');

    Route::post('/ukom/daftarUkomEksternal', [UkomController::class, 'daftarUkomEksternal'])
        ->name('/ukom/daftarUkomEksternal');
});

Route::middleware(['auth', 'handler.response', 'handler.resource', 'handler.method'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('/dashboard');

    // Maintenance
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    require __DIR__ . '/web/maintenance.php';
    require __DIR__ . '/web/user.php';
    require __DIR__ . '/web/siap.php';
    require __DIR__ . '/web/formasi.php';
    require __DIR__ . '/web/akp.php';
    require __DIR__ . '/web/ukom.php';
    require __DIR__ . '/web/security.php';
    require __DIR__ . '/web/pak.php';
    require __DIR__ . '/web/report.php';

    //Verifikkasi
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    Route::get('/task/user_jf', [UserController::class, 'verifikasi'])
        ->name('/task/user_jf');
    Route::post('/task/user_jf/aktivasi/{nip}', [UserController::class, 'aktivasi'])
        ->name('/task/user_jf/aktivasi')
        ->defaults('object', 'Aktivasi User JF');

    Route::post('/task/user_jf/detail/create', [UserController::class, 'detail_create'])
        ->name('/task/user_jf/detail/create')
        ->defaults('object', 'User JF');
    Route::get('/task/user_jf/detail/{nip}', [UserController::class, 'detail'])
        ->name('/task/user_jf/detail');

    Route::post('/task/user_jf/pendidikan/create', [UserController::class, 'pendidikan_create'])
        ->name('/task/user_jf/pendidikan/create');
    Route::get('/task/user_jf/pendidikan/{nip}', [UserController::class, 'pendidikan'])
        ->name('/task/user_jf/pendidikan');

    Route::post('/task/user_jf/jabatan/create', [UserController::class, 'jabatan_create'])
        ->name('/task/user_jf/jabatan/create');
    Route::get('/task/user_jf/jabatan/{nip}', [UserController::class, 'jabatan'])
        ->name('/task/user_jf/jabatan');

    Route::post('/task/user_jf/pangkat/create', [UserController::class, 'pangkat_create'])
        ->name('/task/user_jf/pangkat/create');
    Route::get('/task/user_jf/pangkat/{nip}', [UserController::class, 'pangkat'])
        ->name('/task/user_jf/pangkat');

    Route::post('/task/user_jf/kinerja/create', [UserController::class, 'kinerja_create'])
        ->name('/task/user_jf/kinerja/create');
    Route::get('/task/user_jf/kinerja/{nip}', [UserController::class, 'kinerja'])
        ->name('/task/user_jf/kinerja');

    Route::post('/task/user_jf/kompetensi/create', [UserController::class, 'kompetensi_create'])
        ->name('/task/user_jf/kompetensi/create');
    Route::get('/task/user_jf/kompetensi/{nip}', [UserController::class, 'kompetensi'])
        ->name('/task/user_jf/kompetensi');

    Route::post('/task/user_jf/sertifikasi/create', [UserController::class, 'sertifikasi_create'])
        ->name('/task/user_jf/sertifikasi/create');
    Route::get('/task/user_jf/sertifikasi/{nip}', [UserController::class, 'sertifikasi'])
        ->name('/task/user_jf/sertifikasi');

    //Audit Log
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    Route::get('/audit/riwayat_login', [AuditController::class, 'riwayatLogin'])
        ->name('/audit/riwayat_login');
    Route::get('/audit/riwayat_aktivitas', [AuditController::class, 'riwayatAktivitas'])
        ->name('/audit/riwayat_aktivitas');

    //Pengumuman
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    Route::get('/pengumuman/daftar', [PengumumanController::class, 'index'])
        ->name('/pengumuman/daftar');

    Route::get('/pengumuman/daftar/{id}', [PengumumanController::class, 'detail'])
        ->name('/pengumuman/daftar/detail');


    //CK Editor
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    Route::post('/ck_editor_upload', function (Request $request) {

        $file = $request->file('upload');
        $originName = $file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $fileName . '_' . time() . '.' . $extension;

        $storage = new LocalStorageService();
        $storage->putObject('ck_editor', $fileName, $file);

        return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => Storage::url('ck_editor/' . $fileName)]);
    })->name('/ck_editor_upload')->defaults('object', 'Upload Image');

    //Notificaiton
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    Route::get('/message/notification', function () {
        $userContext = auth()->user();

        $messaging = new MessagingService();
        $notificationList = $messaging->findNotificationAllByGroupCodeAndRecipientId([
            $userContext->role_code, $userContext->role->base
        ], $userContext->nip);
        return response()->json($notificationList->toArray());
    })->name('/message/notification');

    //Search
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------
    Route::prefix('/api/v1')->group(function () {
        Route::get('/user', [ApiController::class, 'searchUser']);
    });
});
