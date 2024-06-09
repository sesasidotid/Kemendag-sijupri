<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Maintenance\Service\JabatanService;
use App\Http\Controllers\Maintenance\Service\PangkatService;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Siap\Service\InstansiService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use App\Http\Controllers\Ukom\Service\UkomPeriodeService;
use App\Http\Controllers\Ukom\Service\UkomService;
use App\Models\Maintenance\SystemConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class LandingPageController extends Controller
{

    public function index()
    {
        $ukomPeriode = new UkomPeriodeService();
        $instansi = new InstansiService();
        $unitKerja = new UnitKerjaService();
        $jabatan = new JabatanService();
        $pangkat = new PangkatService();

        $ukomPeriodeList = $ukomPeriode->findAll();
        $instansiList = $instansi->findAll();
        $unitKerjaList = $unitKerja->findAll();
        $jabatanList = $jabatan->findAll();
        $pangkatList = $pangkat->findAll();

        $systemConfiguration = SystemConfiguration::find("file_persyaratan_ukom");
        $filePersyaratanIntPromosi = $systemConfiguration->property['internal']['promosi'];
        $filePersyaratanIntPerpindahan = $systemConfiguration->property['internal']['perpindahan'];
        $filePersyaratanExtPromosi = $systemConfiguration->property['external']['promosi'];
        $filePersyaratanExtPerpindahan = $systemConfiguration->property['external']['perpindahan'];

        return view('landing.landing', compact(
            'ukomPeriodeList',
            'instansiList',
            'unitKerjaList',
            'jabatanList',
            'pangkatList',
            'filePersyaratanIntPromosi',
            'filePersyaratanIntPerpindahan',
            'filePersyaratanExtPromosi',
            'filePersyaratanExtPerpindahan',
        ));
    }

    public function pageUkomInternal(Request $request)
    {
        $ukomPeriode = new UkomPeriodeService();
        $instansi = new InstansiService();
        $unitKerja = new UnitKerjaService();
        $jabatan = new JabatanService();
        $pangkat = new PangkatService();

        $filePersyaratan = null;
        $ukomPeriode = $ukomPeriode->findAll()[0] ?? null;
        $instansiList = $instansi->findAll();
        $unitKerjaList = $unitKerja->findAll();
        $jabatanList = $jabatan->findAll();
        $pangkatList = $pangkat->findAll();
        $tipe_user = 'internal';
        $jenis_ukom = $request['jenis_ukom'] ?? null;
        $type = $request['type'] ?? null;
        $email = $request['email'] ?? null;
        $ukom = null;

        if ($type == "mengulang"  && $jenis_ukom && $email) {
            if ($request->pendaftaran_code) {
                $ukom = new UkomService();
                $ukom = $ukom->findLatestByEmailAndJenisUkom($email, $jenis_ukom);
            } else {
                $notificationController = new NotificationController();
                return $notificationController->sendUkomExternalEmail($request);
            }
        }
        if ($type && $jenis_ukom && $email) {
            $systemConfiguration = SystemConfiguration::find("file_persyaratan_ukom");
            $filePersyaratan = $systemConfiguration->property['internal'][$jenis_ukom] ?? [];
        }

        return view('landing.ukom_promosi', compact(
            'ukomPeriode',
            'instansiList',
            'unitKerjaList',
            'jabatanList',
            'pangkatList',
            'filePersyaratan',
            'tipe_user',
            'jenis_ukom',
            'type',
            'email',
            'ukom'
        ));
    }

    public function pageUkomExternal(Request $request)
    {
        $ukomPeriode = new UkomPeriodeService();
        $instansi = new InstansiService();
        $unitKerja = new UnitKerjaService();
        $jabatan = new JabatanService();
        $pangkat = new PangkatService();

        $filePersyaratan = null;
        $ukomPeriode = $ukomPeriode->findAll()[0] ?? null;
        $instansiList = $instansi->findAll();
        $unitKerjaList = $unitKerja->findAll();
        $jabatanList = $jabatan->findAll();
        $pangkatList = $pangkat->findAll();
        $tipe_user = 'external';
        $jenis_ukom = $request['jenis_ukom'] ?? null;
        $type = $request['type'] ?? null;
        $email = $request['email'] ?? null;
        $ukom = null;

        if ($type == "mengulang"  && $jenis_ukom && $email) {
            if ($request->pendaftaran_code) {
                $ukom = new UkomService();
                $ukom = $ukom->findLatestByEmailAndJenisUkom($email, $jenis_ukom);
            } else {
                $notificationController = new NotificationController();
                return $notificationController->sendUkomInternalEmail($request);
            }
        }
        if ($type && $jenis_ukom && $email) {
            $systemConfiguration = SystemConfiguration::find("file_persyaratan_ukom");
            $filePersyaratan = $systemConfiguration->property['external'][$jenis_ukom] ?? [];
        }

        return view('landing.ukom_promosi', compact(
            'ukomPeriode',
            'instansiList',
            'unitKerjaList',
            'jabatanList',
            'pangkatList',
            'filePersyaratan',
            'tipe_user',
            'jenis_ukom',
            'type',
            'email',
            'ukom'
        ));
    }

    public function pageUkomDetail(Request $request)
    {
        $ukom = new UkomService();
        $ukomPeriode = new UkomPeriodeService();
        $instansi = new InstansiService();
        $unitKerja = new UnitKerjaService();
        $jabatan = new JabatanService();
        $pangkat = new PangkatService();

        $ukom = $ukom->findByPendaftaranCode($request->pendaftaran_code);
        if (!$ukom) {
            throw new BusinessException([
                "message" => "Kode Pendaftaran Tidak Valid",
                "error code" => "UKM-00001",
                "code" => 500
            ], 500);
        }

        $ukomPeriodeList = $ukomPeriode->findAll();
        $instansiList = $instansi->findAll();
        $unitKerjaList = $unitKerja->findAll();
        $jabatanList = $jabatan->findAll();
        $pangkatList = $pangkat->findAll();

        $isDownloaded = true;
        $file_qrcode = "{$ukom->nip}_{$ukom->pendaftaran_code}_qr.png";
        $qrCodePath = storage_path("app/public/{$file_qrcode}");
        if (!file_exists($qrCodePath)) {
            QrCode::format('png')->size(300)->margin(5)->generate(URL::to("/page/ukom/{$ukom->pendaftaran_code}"), $qrCodePath);

            $manager = new ImageManager(new Driver());
            $qrImage = $manager->read($qrCodePath);
            $qrImage->text("Kode Pendaftaran : \n{$ukom->pendaftaran_code}", 0, 0, function ($font) {
                $font->file(public_path("build/fonts/BodoniflfBold-MVZx.ttf"));
                $font->size(12);
                $font->color('#000000');
                $font->align('left');
                $font->valign('top');
            });

            $qrImage->save($qrCodePath);
            $isDownloaded = false;
        }

        return view('landing.ukom_detail', compact(
            'ukom',
            'isDownloaded',
            'file_qrcode',
        ));
    }
}
