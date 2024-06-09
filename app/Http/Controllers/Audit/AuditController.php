<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;
use App\Models\Audit\AuditAktivitas;
use App\Models\Audit\AuditLogin;
use Illuminate\Http\Request;

class AuditController extends Controller
{

    public function riwayatLogin(Request $request)
    {
        $auditLogin = new AuditLogin;
        $data = $request->all();
        $auditLoginList = $auditLogin->findSearchPaginate($data);

        return view('audit.riwayat_login', compact(
            'auditLoginList'
        ));
    }

    public function riwayatAktivitas(Request $request)
    {
        $auditAktivitas = new AuditAktivitas();
        $data = $request->all();
        $auditAktivitasList = $auditAktivitas->findSearchPaginate($data);

        return view('audit.riwayat_aktivitas', compact(
            'auditAktivitasList'
        ));
    }
}
