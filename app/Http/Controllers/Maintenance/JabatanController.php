<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\JabatanService;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    private $jabatan;

    public function __construct(JabatanService $jabatanService)
    {
        $this->jabatan = $jabatanService;
    }

    public function index()
    {
        $jabatanList = $this->jabatan->findAll();
        return view('maintenance.jabatan.index', compact('jabatanList'));
    }

    public function create()
    {
        return view('maintenance.jabatan.create');
    }

    public function edit()
    {
        return view('maintenance.jabatan.edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->jabatan->fill($request->all());
        $this->jabatan->customSave();

        return redirect()->route('maintenance.jabatan');
    }

    public function update(Request $request)
    {
        return redirect()->route('maintenance.jabatan');
    }

    public function delete()
    {
        return redirect()->route('maintenance.jabatan');
    }
}