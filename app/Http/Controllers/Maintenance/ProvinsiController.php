<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{
    private $provinsi;

    public function __construct(ProvinsiService $provinsiService)
    {
        $this->provinsi = $provinsiService;
    }

    public function index()
    {
        $provinsiList = $this->provinsi->findAll();
        return view('maintenance.provinsi.index', compact('provinsiList'));
    }

    public function detail(Request $request)
    {
        $provinsi = new ProvinsiService();
        $provinsi = $provinsi->findById($request->id);

        return view('maintenance.provinsi.detail', compact(
            'provinsi'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->provinsi->fill($request->all());
        $this->provinsi->customSave();

        return redirect()->route('/maintenance/provinsi');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        $this->provinsi = $this->provinsi->findById($request->id);
        $this->provinsi->fill($request->all());
        $this->provinsi->customUpdate();

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $this->provinsi = $this->provinsi->findById($request->id);
        $this->provinsi->customDelete();
    }
}
