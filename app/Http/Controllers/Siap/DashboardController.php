<?php

namespace App\Http\Controllers\Siap;

use App\Enums\RoleCode;
use App\Enums\UkomStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Formasi\Service\FormasiDocumentService;
use App\Http\Controllers\Security\Service\UserService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use App\Http\Controllers\Ukom\Service\UkomService;

class DashboardController extends Controller
{

    private $unitKerja;
    public function __construct(UnitKerjaService $unitKerjaService)
    {
        $this->unitKerja = $unitKerjaService;
    }

    public function index()
    {
        $userContext = auth()->user();

        switch ($userContext->role->base) {
            case RoleCode::ADMIN_SIJUPRI:
                return $this->sijupri();
            case RoleCode::ADMIN_INSTANSI:
                return $this->instansi();
            case RoleCode::PENGATUR_SIAP:
                return $this->unitkerjaOpd();
            case RoleCode::USER:
                return $this->user();
        }
    }
    public function sijupri()
    {
        $adminCounts = null;
        $instansiCounts = null;
        $pengelolaCounts = null;
        $userCounts = null;
        $this->sijupriCompact($adminCounts, $instansiCounts, $pengelolaCounts, $userCounts);
        $unitKerjaList = $this->unitKerja->findAll();

        return view('dashboard.adminSijupri.index', compact(
            'unitKerjaList',
            'adminCounts',
            'instansiCounts',
            'pengelolaCounts',
            'userCounts',
        ));
    }

    private function sijupriCompact(&$adminCounts, &$instansiCounts, &$pengelolaCounts, &$userCounts)
    {
        $user = new UserService();

        $adminList = $user->findByRoleBase(RoleCode::ADMIN_SIJUPRI);
        $instansiList = $user->findByRoleBase(RoleCode::ADMIN_INSTANSI);
        $pengelolaList = $user->findByRoleBase(RoleCode::PENGATUR_SIAP);
        $userList = $user->findByRoleBase(RoleCode::USER);

        $adminCounts = count($adminList) ?? 0;
        $instansiCounts = count($instansiList) ?? 0;
        $pengelolaCounts = count($pengelolaList) ?? 0;
        $userCounts = count($userList) ?? 0;
    }

    public function instansi()
    {
        $instansiCounts = null;
        $pengelolaCounts = null;
        $userCounts = null;
        $unitKerjaList = null;
        $this->instansiCompact($instansiCounts, $pengelolaCounts, $userCounts, $unitKerjaList);

        return view('dashboard.instansi.index', compact(
            'instansiCounts',
            'pengelolaCounts',
            'userCounts',
            'unitKerjaList'
        ));
    }

    private function instansiCompact(&$instansiCounts, &$pengelolaCounts, &$userCounts, &$unitKerjaList)
    {
        $userContext = auth()->user();
        $user = new UserService();

        $instansiList = $user->findByRoleBaseAndInstansiId(RoleCode::ADMIN_INSTANSI, $userContext->instansi_id);
        $pengelolaList = $user->findByRoleBaseAndInstansiId(RoleCode::PENGATUR_SIAP, $userContext->instansi_id);
        $userList = $user->findByRoleBaseAndInstansiId(RoleCode::USER, $userContext->instansi_id);
        $unitKerjaList = $this->unitKerja->findByTipeInstansiCodeAndInstansiId($userContext->tipe_instansi_code, $userContext->instansi_id);
        $instansiCounts = count($instansiList) ?? 0;
        $pengelolaCounts = count($pengelolaList) ?? 0;
        $userCounts = count($userList) ?? 0;
    }

    public function unitkerjaOpd()
    {
        $formasiDokumenList = null;
        $formasiMessage = null;
        $userCounts = null;
        $this->unitkerjaOpdCompact($formasiDokumenList, $formasiMessage, $userCounts);

        return view('dashboard.opd.index', compact(
            'formasiDokumenList',
            'formasiMessage',
            'userCounts'
        ));
    }

    private function unitkerjaOpdCompact(&$formasiDokumenList, &$formasiMessage, &$userCounts)
    {
        $userContext = auth()->user();
        $formasiDokumen = new FormasiDocumentService();
        $user = new UserService();

        $formasiDokumenList = $formasiDokumen->findByUnitKerjaId($userContext->unit_kerja_id);
        if ($formasiDokumenList) {
            // foreach ($formasiList as $key => $value) {
            //     $timeline = $value->auditTimeline;
            //     $counts = count($timeline) ?? 0;
            //     if ($counts > 0) {
            //         $formasiMessage = $formasiMessage ? $formasiMessage . " - " . $timeline[$counts - 1]->description : "" . $timeline[$counts - 1]->description;
            //     }
            // }
        }

        $userList = $user->findByUnitKerjaIdAndRoleBase($userContext->unit_kerja_id, RoleCode::USER);
        $userCounts = count($userList) ?? 0;
    }

    public function user()
    {
        $ukomMessage = null;
        $akpMessage = null;
        $this->userCompact($ukomMessage, $akpMessage);

        return view('dashboard.user.index', compact(
            'ukomMessage',
            'akpMessage'
        ));
    }

    private function userCompact(&$ukomMessage, &$akpMessage)
    {
        $userContext = auth()->user();
        $ukom = new UkomService();

        $ukom = $ukom->findByNipAndStatusNot($userContext->nip, UkomStatus::SELESAI);
        if ($ukom) {
            $auditTimelineList = $ukom->auditTimeline;
            $ukomMessage = $auditTimelineList[count($auditTimelineList) - 1]->description ?? null;
        }
    }
}
