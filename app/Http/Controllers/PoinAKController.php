<?php

namespace App\Http\Controllers;

use App\Enums\RoleCode;
use App\Models\JenjangPangkat;
use App\Enums\TaskStatus;
use App\Models\PoinAK;
use App\Services\PerformanceReview\PoinAKService;
use App\Http\Controllers\Maintenance\Service\KabKotaService;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use App\Http\Controllers\Security\Service\UserService;
use App\Http\Controllers\Siap\Service\InstansiService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use App\Http\Controllers\Siap\Service\UserDetailService;
use App\Http\Controllers\Siap\Service\UserPakService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class PoinAKController extends Controller
{
    private $poinAKService;

    public function __construct(PoinAKService $poinAKService)
    {
        $this->poinAKService = $poinAKService;
    }
    //DONE - ADMIN - GET
    public function koefisienTampil()
    {
        try {
            $data = $this->poinAKService->getKoefisienData();
            return view('performing.poin_ak.koefisien', $data);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Error fetching Koefisien data');
        }
    }
    //DONE - ADMIN - GET ALL
    public function tampilSemuaUsers()
    {
        $poinAKs = $this->poinAKService->getAllPoinAKs();

        return view('pr.admin.index', compact('poinAKs'));
    }

    //DONE - ADMIN - GET BY ID
    public function tampilAKUserAdmin($userId)
    {
        $poinAKs = $this->poinAKService->getPoinAKsForUser($userId);
        return view('perf.poin_ak.user_detail', compact('poinAKs'));
    }


    //DONE - ADMIN - UPDATE
    public function tampilAKUserEdit($userId)
    {
        $poinAKs = $this->poinAKService->getPoinAKsForUser($userId);
        return view('pr.admin.detail', compact('poinAKs'));
    }
    //DONE - ADMIN - UPDATE
    public function changeApprovalStatusVerifikasi(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status'); // 0 for disapprove, 1 for approve
        $result = $this->poinAKService->changeStatusVerifikasi($id, $status);
        return response()->json($result);
    }
    //DONE - ADMIN - UPDATE
    public function changeApprovalStatusSelesai(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status'); // 0 for disapprove, 1 for approve
        $result = $this->poinAKService->changeStatusSelesai($id, $status);
        return response()->json($result);
    }
    //DONE - ADMIN -PUT/UPDATE
    public function updateAngkaKredit(Request $request, $id)
    {
        try {
            $poinAK = PoinAK::findOrFail($id);
            $success = $this->poinAKService->updateAngkaKredit($poinAK, $request->all());
            if ($success) {
                return redirect()->route('performing.poin_ak.user_detail', ['userId' => $poinAK->user_id])
                    ->with('success', 'Angka Kredit information updated successfully');
            }
            return redirect()->back()->with('error', 'Error updating Angka Kredit information');
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Error updating Angka Kredit information');
        }
    }


    //DONE - USER - GET
    public function tampilAKUser()
    {
        $userJF = Auth::user();

        $userId = $userJF->userDetail->id;

        $poinAKs = $this->poinAKService->getPoinAKsForUser($userId);

        return view('pr.user.detail', compact('poinAKs'));
    }

    //DONE - USER - GET/SHOW
    public function showForm()
    {
        // return view('performing.poin_ak.submitForm');
        return "ok";
    }
    //DONE - USER - POST/CREATE
    public function submitForm(Request $request, Guard $auth)
    {

        try {
            $this->poinAKService->processForm($request, $auth);
            return redirect()->back()->with('success', 'Form submitted successfully!');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'An error occurred during form submission.');
        }
    }

    public function pemetaanPAK(Request $request)
    {
        $user = new UserService();
        $provinsi = new ProvinsiService();
        $kabkota = new KabKotaService();
        $instansi = new InstansiService();
        $unitKerja = new UnitKerjaService();

        $data = $request->all();
        $data['attr']['role']['base'] = RoleCode::USER;
        $data['attr']['delete_flag'] = false;

        $data['cond']['role_code'] = '=';
        $data['cond']['instansi']['kabKota']['kabupaten_id'] = '=';
        $data['cond']['unit_kerja_id'] = '=';
        $data['cond']['instansi_id'] = '=';
        $data['cond']['delete_flag'] = '=';
        $data['ordrs']['nip'] = 'ASC';
        $userList = $user->findSearchPaginate($data);
        $provinsiList = $provinsi->findAll();
        $kabkotaList = $kabkota->findAll();
        $instansiList = $instansi->findAll();
        $unitkerjaList = $unitKerja->findAll();

        return view('pak.pemetaan_pak', compact(
            'userList',
            'provinsiList',
            'kabkotaList',
            'instansiList',
            'unitkerjaList',
        ));
    }

    public function detailUserpak(Request $request)
    {
        $user = new UserService();
        $userPak = new UserPakService();

        $user = $user->findById($request->nip);
        $userPakList = $userPak->findByNipAndNotReject($request->nip);

        return view('pak.detail_user_pak', compact(
            'user',
            'userPakList',
        ));
    }

    public function verifikasiTaskStatus(Request $request)
    {
        $validation = ['task_status' => 'required'];
        if ($request->task_status == TaskStatus::REJECT) {
            $validation['comment'] = 'required';
        }
        $request->validate($validation);

        DB::transaction(function () use ($request) {
            $userPak = new UserPakService();
            $userDetail = new UserDetailService();
            $userPak = $userPak->findById($request->id);

            $userPak->task_status = $request->task_status;
            $userPak->comment = $request->comment ?? null;
            $userPak->customUpdate();

            $nip = $userPak->nip;
            $userPak = $userPak->findLatestByNip($nip);

            $userDetail = $userDetail->findByNip($nip);
            $userDetail->user_pak_id = $userPak->id ?? null;
            $userDetail->customUpdate();
        });

        return redirect()->back();
    }



    //-------------------------------------------------------MAINTAINANCE---------------------------------------------------------------------------

    //MAINTAINANCE
    public function downloadPAK($file)
    {
        return $this->poinAKService->downloadPAK($file);
    }
    //MAINTAINANCE
    public function createUserPointsForm()
    {
        return view('performing.poin_ak.performing', $this->poinAKService->getUserPointsFormData());
    }
    //MAINTAINANCE
    public function storeUserPoints(Request $request)
    {
        $result = $this->poinAKService->calculateUserPoints($request);

        if (isset($result['error'])) {
            return view('performing.poin_ak.performing', ['error' => $result['error']]);
        }

        return view('performing.poin_ak.performing', $result);
    }
    //MAINTAINANCE
    public function showPerhitunganAK()
    {
        $jenjangNames = JenjangPangkat::pluck('jenjang', 'id')->toArray();
        return view('performing.poin_ak.maxpoint', ['jenjangNames' => $jenjangNames]);
    }

    //MAINTAINANCE
    public function calculatePangkat(Request $request)
    {
        $jenjang_id = $request->input('jenjang_id');
        $point = $request->input('point');

        $result = $this->poinAKService->calculatePangkat($jenjang_id, $point);

        if (is_string($result)) {
            return $result;
        }

        $jenjangNames = $result['jenjangNames'];

        return view('performing.poin_ak.maxpoint', compact('result', 'jenjangNames'));
    }
}
