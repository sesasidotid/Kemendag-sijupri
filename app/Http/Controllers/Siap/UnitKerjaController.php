<?php

namespace App\Http\Controllers\Siap;

use App\Enums\RoleCode;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Formasi\Service\FormasiResultService;
use App\Http\Controllers\Formasi\Service\FormasiService;
use App\Http\Controllers\Maintenance\Service\WilayahService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitKerjaController extends Controller
{
    private $unitKerja;

    public function __construct(UnitKerjaService $unitKerjaService)
    {
        $this->unitKerja = $unitKerjaService;
    }

    public function index()
    {
        $userContext = auth()->user();
        switch ($userContext->role->base) {
            case RoleCode::ADMIN_SIJUPRI:
                $unitKerjaList = $this->unitKerja->findSearchPaginate([]);

                if ($userContext->roleCode === RoleCode::ADMIN_FORMASI) {
                    return view('sijupri.opd.index', compact(
                        'unitKerjaList'
                    ));
                } else {
                    return view('sijupri.opd.index_v2', compact(
                        'unitKerjaList'
                    ));
                }
            case RoleCode::ADMIN_INSTANSI:
                $userContext = auth()->user();

                $data = [];
                $data['attr']['instansi']['tipe_instansi_code'] = $userContext->tipe_instansi_code;
                $data['attr']['instansi_id'] = $userContext->instansi_id;
                $unitKerjaList = $this->unitKerja->findSearchPaginate($data);
                return view('instansi.opd.index', compact(
                    'unitKerjaList'
                ));
            default:
                break;
        }
    }

    public function listOpd()
    {

        $unitKerjaList = $this->unitKerja->findAll();
        return view('sijupri.opd.index', compact(
            'unitKerjaList'
        ));
    }

    public function opd()
    {
        $userContext = auth()->user();

        $unitKerjaList = $this->unitKerja->findByTipeInstansiCodeAndInstansiId($userContext->tipe_instansi_code, $userContext->instansi_id);
        return view('instansi.opd.index', compact(
            'unitKerjaList'
        ));
    }

    public function detail(Request $request)
    {
        $userContext = auth()->user();
        $wilayah = new WilayahService();

        $role = $userContext->role;
        $unitKerja = $this->unitKerja->findById($request->id);
        $unitKerjaContext = $userContext->unitKerja;
        $wilayahList = $wilayah->findAll();
        $provinsi = $unitKerjaContext->provinsi ?? null;
        $kabupaten = $unitKerjaContext->kabupaten ?? null;
        $kota = $unitKerjaContext->kota ?? null;
        $instansi = $userContext->instansi;

        return view('maintenance.unitkerja.detail', compact(
            'unitKerja',
            'wilayahList',
            'provinsi',
            'kabupaten',
            'kota',
            'wilayahList',
            'instansi',
        ));
    }

    public function detailSijupri(Request $request)
    {
        $userContext = auth()->user();
        $wilayah = new WilayahService();

        $unitKerja = $this->unitKerja->findById($request->id);
        $unitKerjaContext = $userContext->unitKerja;
        $provinsi = $unitKerjaContext->provinsi ?? null;
        $kabupaten = $unitKerjaContext->kabupaten ?? null;
        $kota = $unitKerjaContext->kota ?? null;
        $instansi = $userContext->instansi;

        return view('maintenance.unitkerja.detail_sijupri', compact(
            'unitKerja',
            'provinsi',
            'kabupaten',
            'kota',
            'instansi',
        ));
    }

    public function create()
    {
        $userContext = auth()->user();
        $wilayah = new WilayahService();

        $role = $userContext->role;
        $unitKerjaList = $this->unitKerja->findByTipeInstansiCodeAndInstansiId($userContext->tipe_instansi_code, $userContext->instansi_id);
        $unitKerjaContext = $userContext->unitKerja;
        $wilayahList = $wilayah->findAll();
        $provinsi = $unitKerjaContext->provinsi ?? null;
        $kabupaten = $unitKerjaContext->kabupaten ?? null;
        $kota = $unitKerjaContext->kota ?? null;
        $instansi = $userContext->instansi;

        return view('maintenance.unitkerja.create', compact(
            'unitKerjaList',
            'wilayahList',
            'provinsi',
            'kabupaten',
            'kota',
            'wilayahList',
            'instansi',
        ));
    }

    public function edit()
    {
        return view('siap.opd.edit');
    }

    public function formasi($id)
    {
        $unitKerja = new UnitKerjaService();
        $unitKerja = $unitKerja->findById($id);

        $formasi = new FormasiService();
        $formasiPenera = $formasi->findByUnitKerjaIdAndJabatanCode($id, 'penera') ?? null;
        $formasiAndag = $formasi->findByUnitKerjaIdAndJabatanCode($id, 'analis_perdagangan') ?? null;
        $formasiPengTera = $formasi->findByUnitKerjaIdAndJabatanCode($id, 'pengamat_tera') ?? null;
        $formasiPengMetro = $formasi->findByUnitKerjaIdAndJabatanCode($id, 'pengawas_kemetrologian') ?? null;
        $formasiPenDag = $formasi->findByUnitKerjaIdAndJabatanCode($id, 'pengawas_perdagangan') ?? null;
        $formasiPMB = $formasi->findByUnitKerjaIdAndJabatanCode($id, 'penguji_mutu_barang') ?? null;

        return view('siJupri.opd.formasi', compact(
            'formasiPenera',
            'formasiAndag',
            'formasiPengTera',
            'formasiPengMetro',
            'formasiPenDag',
            'formasiPMB',
            'id'
        ));
    }

    public function formasi_utama(Request $request)
    {
        $formasiResultNew = [];
        $formasiNew = [];
        $formasiNew['unit_kerja_id'] = $request['unit_kerja_id'];
        $formasiNew['jabatan_code'] = $request['jabatan_code'];

        $formasi = new FormasiService();
        $formasiOld = $formasi->findByUnitKerjaIdAndJabatanCode($request['unit_kerja_id'], $request['jabatan_code']);
        if ($formasiOld) {
            $formasi = $formasiOld;
            foreach ($request['pembulatan'] as $key => $value) {
                $formasiResult = new FormasiResultService();
                $formasiResultOld = $formasiResult->findByFormasiIdAndJenjangCode($formasi->id, $key);
                if ($formasiResultOld)
                    $formasiResult = $formasiResultOld;

                $formasiResult->jenjang_code = $key;
                $formasiResult->pembulatan = $value;
                $formasiResult->sdm = 0;
                $formasiResult->total = 0;
                $formasiResultNew[] = $formasiResult;
                $formasiNew['total'] = ($formasiNew['total'] ?? 0) + $value;
            }
            $formasi->fill($formasiNew);
            $formasi->task_status = TaskStatus::PENDING;

            DB::transaction(function () use ($formasi, $formasiResultNew) {
                $formasi->customUpdate();
                foreach ($formasiResultNew as $key => $value) {
                    $value->customUpdate();
                }
            });
        } else {
            foreach ($request['pembulatan'] as $key => $value) {
                $formasiResult = new FormasiResultService();
                $formasiResult->jenjang_code = $key;
                $formasiResult->pembulatan = $value;
                $formasiResult->sdm = 0;
                $formasiResult->total = 0;
                $formasiResultNew[] = $formasiResult;
                $formasiNew['total'] = ($formasiNew['total'] ?? 0) + $value;
            }
            $formasi->fill($formasiNew);
            $formasi->task_status = TaskStatus::PENDING;

            DB::transaction(function () use ($formasi, $formasiResultNew) {
                $formasi->customSave();
                foreach ($formasiResultNew as $key => $value) {
                    $value->formasi_id = $formasi->id;
                    $value->customSave();
                }
            });
        }

        return redirect()->route('siap.unit_kerja.formasi', ['id' => $request['unit_kerja_id']]);
    }

    public function store(Request $request)
    {
        $userContext = auth()->user();
        $unitKerja = new UnitKerjaService();

        $validaton = [
            "name" => 'required',
            "email" => 'required|email',
            "phone" => 'required:min:10|max:15',
            "alamat" => 'required',
            "latitude" => 'required',
            "longitude" => 'required',
        ];
        if ($userContext->role->base == RoleCode::ADMIN_SIJUPRI) {
            $validaton['tipe_instansi_code'] = 'required';
            $validaton['provinsi_id'] = 'required';
            $validaton['kabupaten_id'] = 'required';
        } else if ($userContext->role->base == RoleCode::ADMIN_INSTANSI) {
            // $request['tipe_instansi_code'] = $userContext->tipe_instansi_code;
            // if ($userContext->tipe_instansi_code === 'provinsi') {
            //     $request['provinsi_id'] = $userContext->unitKerja->instansi->provinsi_id;
            // } else if ($userContext->tipe_instansi_code === 'kabupaten') {
            //     $request['provinsi_id'] = $userContext->unitKerja->instansi->provinsi_id;
            //     $request['kabupaten_id'] = $userContext->unitKerja->instansi->kabupaten_id;
            // } else if ($userContext->tipe_instansi_code === 'kota') {
            //     $request['provinsi_id'] = $userContext->unitKerja->instansi->provinsi_id;
            //     $request['kota_id'] = $userContext->unitKerja->instansi->kota_id;
            // }

            $request['tipe_instansi_code'] = $userContext->tipe_instansi_code;
            $request['instansi_id'] = $userContext->instansi_id;
        }
        $request->validate($validaton);

        $unitKerja->fill($request->all());
        $unitKerja->customSave();

        return redirect()->route('/maintenance/unit_kerja_instansi_daerah');
    }

    public function update(Request $request)
    {
        $unitKerja = new UnitKerjaService();

        $validaton = [
            "name" => 'required',
            "email" => 'required|email',
            "phone" => 'required:min:10|max:15',
            "alamat" => 'required',
            "latitude" => 'required',
            "longitude" => 'required',
        ];
        $request->validate($validaton);

        $unitKerja = $unitKerja->findById($request->id);
        $unitKerja->fill($request->all());
        $unitKerja->customSave();

        return redirect()->back();
    }

    public function updateSijupri(Request $request)
    {
        $unitKerja = new UnitKerjaService();

        $validaton = [
            "latitude" => 'required',
            "longitude" => 'required',
        ];
        $request->validate($validaton);

        $unitKerja = $unitKerja->findById($request->id);
        $unitKerja->fill($request->all());
        $unitKerja->customSave();

        return redirect()->back();
    }
}
