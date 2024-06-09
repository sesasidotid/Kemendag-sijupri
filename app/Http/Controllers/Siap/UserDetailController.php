<?php

namespace App\Http\Controllers\Siap;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Siap\Service\UserDetailService;
use Illuminate\Http\Request;

class UserDetailController extends Controller
{
    private $userDetail;

    public function __construct(UserDetailService $userDetailService)
    {
        $this->userDetail = $userDetailService;
    }

    public function create(Request $request)
    {
        $page = 1;
        return view('profile.edit', compact('page'));
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'nik' => 'required',
        //     'tempat_lahir' => 'required',
        //     'tanggal_lahir' => 'required',
        //     'email' => 'required',
        //     'nomor_hp' => 'required',
        //     'file_ktp' => 'required',
        // ]);

        $this->userDetail->fill($request->all());
        $this->userDetail->customSave($request->all());
        session()->flash('response', ['message' => 'Data Berhasil Ditambahkan']);
        return redirect()->back();
    }
}
