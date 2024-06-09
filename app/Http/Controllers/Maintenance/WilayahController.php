<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\WilayahService;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    private $wilayah;

    public function __construct(WilayahService $wilayahService)
    {
        $this->wilayah = $wilayahService;
    }

    public function index()
    {
        $data = $this->wilayah->findAll();
        return view('maintenance.wilayah.index', compact('data'));
    }

    public function create()
    {
        return view('maintenance.wilayah.create');
    }

    public function edit()
    {
        return view('maintenance.wilayah.edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->wilayah->fill($request->all());
        $this->wilayah->customSave();

        return redirect()->route('maintenance.wilayah');
    }

    public function update(Request $request)
    {
        return redirect()->route('maintenance.wilayah');
    }

    public function delete()
    {
        return redirect()->route('maintenance.wilayah');
    }
}
