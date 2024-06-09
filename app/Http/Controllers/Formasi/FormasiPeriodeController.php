<?php

namespace App\Http\Controllers\Formasi;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Formasi\Service\FormasiPeriodeService;
use Illuminate\Http\Request;

class FormasiPeriodeController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'file_surat_undangan' => 'required|mimes:pdf|max:2048'
        ]);
        $request['periode'] = $request['periode'] . '-01';

        $formasiPeriode = new FormasiPeriodeService();
        $formasiPeriode->fill($request->all());
        $formasiPeriode->customSaveWithUpload($request->all());

        return redirect()->back();
    }
}
