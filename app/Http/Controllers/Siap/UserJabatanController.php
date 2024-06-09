<?php

namespace App\Http\Controllers\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Siap\Service\UserJabatanService;
use App\Models\Maintenance\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserJabatanController extends Controller
{
    private $userJabatan;

    public function __construct(UserJabatanService $userJabatanService)
    {
        $this->userJabatan = $userJabatanService;
    }

    public function edit(Request $request)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'tmt' => 'required',
            'tipe_jabatan' => 'required',
            'pangkat_id' => 'required',
            'file_sk_jabatan' => 'required',
            'file_sk_pangkat' => 'required',
        ]);

        if ($request->tipe_jabatan === "JF") {
            $request->validate(['jabatan_code' => 'required']);
            $request['name'] = Jabatan::where('code', $request['jabatan_code'])->first()?->name ?? null;
        } else {
            $request['name'] = $request['pangkat'];
        }

        $this->userJabatan->fill($request->all());
        $this->userJabatan->customSaveWithUpload($request->all());
        session()->flash('response', ['message' => 'Data Berhasil Ditambahkan']);

        $page = $request->query('page');
        if ($page)
            return redirect()->route('profile.edit', ['page' => $page]);
        return redirect()->back();
    }

    public function destroy()
    {
    }
}
