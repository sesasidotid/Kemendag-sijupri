<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\KabKotaService;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use Illuminate\Http\Request;

class KabKotaController extends Controller
{
    private $kabKota;

    public function __construct(KabKotaService $kabKotaService)
    {
        $this->kabKota = $kabKotaService;
    }

    public function index($type)
    {
        $data = $this->kabKota->findAll();
        if ($type == 'kota')
            return view('maintenance.kota.index', compact('data'));
        else
            return view('maintenance.kabupaten.index', compact('data'));
    }

    public function kabupaten()
    {
        $kabupatenList = $this->kabKota->findByType('KABUPATEN');
        $provinsiList = new ProvinsiService();
        $provinsiList = $provinsiList->findAll();
        return view('maintenance.kabupaten.index', compact('kabupatenList', 'provinsiList'));
    }

    public function kota()
    {
        $kotaList = $this->kabKota->findByType('KOTA');
        $provinsiList = new ProvinsiService();
        $provinsiList = $provinsiList->findAll();
        return view('maintenance.kota.index', compact('kotaList', 'provinsiList'));
    }

    public function detailKabupaten(Request $request)
    {
        $kabupaten = new KabKotaService();
        $provinsiList = new ProvinsiService();

        $kabupaten = $kabupaten->findById($request->id);
        $provinsiList = $provinsiList->findAll();

        return view('maintenance.kabupaten.detail', compact(
            'kabupaten',
            'provinsiList'
        ));
    }

    public function detailKota(Request $request)
    {
        $kota = new KabKotaService();
        $provinsiList = new ProvinsiService();

        $kota = $kota->findById($request->id);
        $provinsiList = $provinsiList->findAll();

        return view('maintenance.kota.detail', compact(
            'kota',
            'provinsiList'
        ));
    }

    public function update()
    {
        return view('maintenance.kabKota.update');
    }

    public function storeKabupaten(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'provinsi_id' => 'required',
        ]);

        $this->kabKota->fill($request->all());
        $this->kabKota->type = "KABUPATEN";
        $this->kabKota->customSave();

        return redirect()->route('/maintenance/kabupaten');
    }

    public function storeKota(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'provinsi_id' => 'required',
        ]);

        $this->kabKota->fill($request->all());
        $this->kabKota->type = "KOTA";
        $this->kabKota->customSave();

        return redirect()->route('/maintenance/kota');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->kabKota->fill($request->all());
        $this->kabKota->customSave();

        return redirect()->route('maintenance.kabKota');
    }

    public function updateKabupaten(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'provinsi_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $this->kabKota = $this->kabKota->findById($request->id);
        $this->kabKota->fill($request->all());
        $this->kabKota->type = "KABUPATEN";
        $this->kabKota->customUpdate();

        return redirect()->back();
    }

    public function updateKota(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'provinsi_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $this->kabKota = $this->kabKota->findById($request->id);
        $this->kabKota->fill($request->all());
        $this->kabKota->type = "KOTA";
        $this->kabKota->customUpdate();

        return redirect()->back();
    }

    public function delete()
    {
        return redirect()->route('maintenance.kabKota');
    }
}
