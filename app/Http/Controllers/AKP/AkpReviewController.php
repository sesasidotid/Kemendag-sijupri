<?php

namespace App\Http\Controllers\AKP;

use App\Http\Controllers\AKP\Service\AkpMatrixService;
use App\Http\Controllers\AKP\Service\AkpService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AkpReviewController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $userContext = auth()->user();

        $akp = new AkpService();
        $akpList = $akp->findByNip($userContext->nip);
        return view('akp.review', compact('akpList'));
    }

    public function personal($id)
    {
        return view('akp.review_personal', compact('id'));
    }

    public function rekomendasi($id)
    {
        $akp = new AkpService();
        $akp = $akp->findById($id);

        $akpInstrumen = $akp->akpInstrumen;
        $akpMatrix = new AkpMatrixService();
        $akpMatrixList = $akpMatrix->findByAkpIdAndRelevansi($id, "Relevan");

        return view('akp.review_rekomendasi', compact(
            'akp',
            'akpInstrumen',
            'akpMatrixList',
        ));
    }

    public function atasan(Request $request, $nip)
    {
        if (!$request->hasValidSignature()) {
            abort(404);
        }
        return view('akp.review_atasan', compact('nip'));
    }

    public function rekan(Request $request, $nip)
    {
        if (!$request->hasValidSignature()) {
            abort(404);
        }
        return view('akp.review_rekan', compact('nip'));
    }

    public function selesai()
    {
        return view('akp.review_selesai');
    }

    public function failed(Request $request)
    {
        $message = $request->message;
        return view('akp.review_failed', compact(
            'message'
        ));
    }
}
