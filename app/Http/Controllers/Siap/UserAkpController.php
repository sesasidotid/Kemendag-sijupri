<?php

namespace App\Http\Controllers\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Siap\Service\UserAkpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAkpController extends Controller
{
    private $userAkp;

    public function __construct(UserAkpService $userAkpService)
    {
        $this->userAkp = $userAkpService;
    }

    public function edit(Request $request)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'kategori' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $this->userAkp->fill($request->all());
        $this->userAkp->customSave();
        session()->flash('response', ['message' => 'Data Berhasil Ditambahkan']);
        return redirect()->back();
    }

    public function destroy()
    {
    }
}
