<?php

namespace App\Http\Controllers\Formasi;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Formasi\Service\FormasiDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormasiTaskController extends Controller
{

    public function index()
    {
        return view('formasi.task.index');
    }

    public function detail(Request $request)
    {
        $formasiDocument = new FormasiDocumentService();

        $formasiDocumentArray = $formasiDocument->getDokumenFormasi()->toArray();
        foreach ($formasiDocumentArray as $key => $value) {
            if (Str::contains($key, 'file')) {
                if (!$value) {
                    return view('formasi.task.detail.dokumen');
                }
            }
        }
        return view('formasi.task.detail.dokumen');
    }
}
