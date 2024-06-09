<?php

namespace App\Http\Controllers\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Siap\Service\UserPakService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserPakController extends Controller
{
    private $userPak;

    public function __construct(UserPakService $userPakService)
    {
        $this->userPak = $userPakService;
    }

    public function edit(Request $request)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'nilai_kinerja' => 'required',
            'nilai_perilaku' => 'required',
            'angka_kredit' => 'required',
            'predikat' => 'required',
            'pak' => 'required',
        ]);

        $this->userPak->fill($request->all());
        $this->userPak->customSave();
        session()->flash('response', ['message' => 'Data Berhasil Ditambahkan']);
        return redirect()->back();
    }

    public function destroy()
    {
    }
}
