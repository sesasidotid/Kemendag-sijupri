<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\JenjangService;
use Illuminate\Http\Request;

class JenjangController extends Controller
{
    private $jenjang;

    public function __construct(JenjangService $jenjangService)
    {
        $this->jenjang = $jenjangService;
    }

    public function index()
    {
        $jenjangList = $this->jenjang->findAll();
        return view('maintenance.jenjang.index', compact('jenjangList'));
    }

    public function create()
    {
        return view('maintenance.jenjang.create');
    }

    public function edit()
    {
        return view('maintenance.jenjang.edit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->jenjang->fill($request->all());
        $this->jenjang->customSave();

        return redirect()->route('maintenance.jenjang');
    }

    public function update(Request $request)
    {
        return redirect()->route('maintenance.jenjang');
    }

    public function delete()
    {
        return redirect()->route('maintenance.jenjang');
    }
}
