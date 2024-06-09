<?php

namespace App\Http\Controllers\Ukom;

use App\Enums\RoleCode;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\MessagingService;
use App\Http\Controllers\Ukom\Service\UkomPeriodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UkomPeriodeController extends Controller
{

    public function index()
    {
        $ukomPeriode = new UkomPeriodeService();
        $ukomPeriodeList = $ukomPeriode->findAllExcludeInactiveFlag();
        return view('ukom.periode', compact(
            'ukomPeriodeList'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'tgl_mulai_pendaftaran' => 'required',
            'tgl_tutup_pendaftaran' => 'required',
            'judul' => 'required',
            'content' => 'required',
        ]);
        $request['periode'] = $request['periode'] . '-01';

        DB::transaction(function () use ($request) {
            $messaging = new MessagingService();
            $ukomPeriode = new UkomPeriodeService();

            if ($ukomPeriode->findByPeriode($request['periode'])) {
                throw new BusinessException([
                    "message" => "Periode Sudah Ada",
                    "error code" => "UKOM-00021",
                    "code" => 500
                ], 500);
            }

            $ukomPeriode->updateAllInactive();
            $announcement = $messaging->createAnnouncement($request->judul, $request->content, RoleCode::USER);

            $ukomPeriode->fill($request->all());
            $ukomPeriode->announcement_id = $announcement->id;
            $ukomPeriode->customSave();
        });

        return redirect()->back();
    }

    public function toggleActivation(Request $request)
    {
        DB::transaction(function () use ($request) {
            $ukomPeriode = new UkomPeriodeService();
            $ukomPeriode->updateAllInactive([$request->id]);

            $ukomPeriode = $ukomPeriode->findById($request->id);
            $ukomPeriode->inactive_flag = !$ukomPeriode->inactive_flag;
            if (strtotime($ukomPeriode->tgl_tutup_pendaftaran) < strtotime(date('Y-m-d'))) {
                throw new BusinessException([
                    "message" => "Pendaftaran sudah ditutup",
                    "error code" => "UKOM-00022",
                    "code" => 500
                ], 500);
            } else $ukomPeriode->customUpdate();
        });

        return redirect()->back();
    }

    public function detail(Request $request)
    {
        $ukomPeriode = new UkomPeriodeService();
        $ukomPeriode = $ukomPeriode->findById($request->id);

        return view('ukom.periode_detail', compact(
            'ukomPeriode'
        ));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'tgl_mulai_pendaftaran' => 'required',
            'tgl_tutup_pendaftaran' => 'required',
            'judul' => 'required',
            'content' => 'required',
        ]);
        $request['periode'] = $request['periode'] . '-01';

        DB::transaction(function () use ($request) {
            $messaging = new MessagingService();
            $ukomPeriode = new UkomPeriodeService();

            $ukomPeriode = new UkomPeriodeService();
            $ukomPeriode = $ukomPeriode->findById($request->id);
            $messaging->updateAnnouncement($ukomPeriode->announcement_id, $request->judul, $request->content);


            $ukomPeriode->fill($request->all());
            $ukomPeriode->customUpdate();
        });

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $ukomPeriode = new UkomPeriodeService();
        $ukomPeriode = $ukomPeriode->findById($request->id);
        $ukomPeriode->customDelete();

        return redirect()->back();
    }
}
