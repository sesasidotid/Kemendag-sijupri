<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\PendidikanService;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    private $pendidikan;

    public function __construct(PendidikanService $pendidikanService)
    {
        $this->pendidikan = $pendidikanService;
    }

    public function index()
    {
        $pendidikanList = $this->pendidikan->findAll();
        return view('maintenance.pendidikan.index', compact('pendidikanList'));
    }

    public function create()
    {
        return view('maintenance.pendidikan.create');
    }

    public function edit()
    {
        return view('maintenance.pendidikan.edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->pendidikan->fill($request->all());
        $this->pendidikan->customSave();

        return redirect()->route('maintenance.pendidikan');
    }

    public function update(Request $request)
    {
        return redirect()->route('maintenance.pendidikan');
    }

    public function delete()
    {
        return redirect()->route('maintenance.pendidikan');
    }
}
