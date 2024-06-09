<?php

namespace App\Http\Controllers\AKP;

use App\Http\Controllers\AKP\Service\AkpMatrixService;
use App\Http\Controllers\AKP\Service\AkpService;
use App\Http\Controllers\Controller;
use App\Models\AKP\AkpPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AkpMatrixController extends Controller
{

    public function updateRekomendasiPelatihan(Request $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request['akpMatrix'] as $key => $value) {
                $akpMatrix = new AkpMatrixService();
                $akpMatrix = $akpMatrix->findById($key);
                $akpMatrix->pelatihan_id = $value;
                $akpMatrix->customUpdate();
            }
        });

        return redirect()->back();
    }
}
