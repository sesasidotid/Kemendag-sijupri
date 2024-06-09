<?php

namespace App\Http\Controllers\AKP;

use App\Enums\RoleCode;
use App\Exports\AkpExport;
use App\Http\Controllers\AKP\Service\AkpMatrixService;
use App\Http\Controllers\AKP\Service\AkpService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\KabKotaService;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use App\Http\Controllers\Security\Service\UserService;
use App\Http\Controllers\Siap\Service\InstansiService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use App\Models\AKP\AkpPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AkpController extends Controller
{

    public function index()
    {
        $userContext = auth()->user();

        $akp = new AkpService();
        $akpList = $akp->findByNip($userContext->nip);
        return view('akp.index', compact('akpList'));
    }

    public function admin_index()
    {
        $akp = new AkpService();
        $akpList = $akp->findAll();

        return view('akp.daftar_akp', compact(
            'akpList',
        ));
    }

    public function admin_detail($id)
    {
        $akp = new AkpService();
        $akpData = $akp->findById($id);

        $akpPelatihan = new AkpPelatihan();
        $akpPelatihanList = $akpPelatihan->where('delete_flag', false)->get();
        $user = $akpData->user;

        return view('akp.detail_akp', compact(
            'akpData',
            'user',
            'akpPelatihanList',
        ));
    }

    public function updateAkpMatrix(Request $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request['matrix'] as $akp_matrix_id => $value) {
                $akpMatrix = new AkpMatrixService();
                $akpMatrix = $akpMatrix->findById($akp_matrix_id);
                $akpMatrix->akp_pelatihan_id = $value['akp_pelatihan_id'];
                $akpMatrix->relevansi = $value['relevansi'];
                $akpMatrix->customUpdate();
            }
        });

        return redirect()->back();
    }

    public function userJf(Request $request)
    {
        $user = new UserService();
        $provinsi = new ProvinsiService();
        $kabkota = new KabKotaService();
        $instansi = new InstansiService();
        $unitKerja = new UnitKerjaService();
        $data = $request->all();

        $data['attr']['role']['base'] = RoleCode::USER;
        $data['attr']['delete_flag'] = false;
        $data['cond']['instansi']['kabKota']['kabupaten_id'] = '=';
        $data['cond']['instansi_id'] = '=';
        $data['cond']['unit_kerja_id'] = '=';
        $userList = $user->findSearchPaginate($data);
        $provinsiList = $provinsi->findAll();
        $kabkotaList = $kabkota->findAll();
        $instansiList = $instansi->findAll();
        $unitkerjaList = $unitKerja->findAll();


        return view('akp.pemetaan_akp', compact(
            'userList',
            'provinsiList',
            'kabkotaList',
            'instansiList',
            'unitkerjaList',
        ));
    }

    public function daftarUserAKP(Request $request)
    {
        $user = new UserService();
        $akp = new AkpService();

        $user = $user->findById($request->nip);
        $akpList = $akp->findByNip($user->nip);

        return view('akp.daftar_user_akp', compact(
            'user',
            'akpList',
        ));
    }

    public function export(Request $request)
    {
        $akp = new AkpService();
        $akp = $akp->findById($request->id);
        return Excel::download(new AkpExport($akp->id), 'akp_data_' . $akp->nip . '.xlsx');
    }

    public function create()
    {
        return view('akp.create');
    }

    public function uploadRekomendasi(Request $request)
    {
        DB::transaction(function () use ($request) {
            $akp = new AkpService();
            $akp = $akp->findById($request->id);

            $file = $request['file_rekomendasi'];
            $fileName = $akp->id . '_.' . $file->getClientOriginalExtension();

            $akp->file_rekomendasi = 'akp/' . $fileName;
            $akp->customUpdate();

            $storage = new LocalStorageService();
            $storage->putObject('akp', $fileName, $file);
        });

        return redirect()->back();
    }
}
