<?php

namespace App\Http\Controllers\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Siap\Service\UserPendidikanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserPendidikanController extends Controller
{
    private $userPendidikan;

    public function __construct(UserPendidikanService $userPendidikanService)
    {
        $this->userPendidikan = $userPendidikanService;
    }

    public function edit(Request $request)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'jurusan' => 'required',
            'instansi_pendidikan' => 'required',
            'file_ijazah' => 'required',
        ]);

        $this->userPendidikan->fill($request->all());
        $this->userPendidikan->customSaveWithUpload($request->all());
        session()->flash('response', ['message' => 'Data Berhasil Ditambahkan']);
        return redirect()->back();
    }

    public function destroy()
    {
    }
}
