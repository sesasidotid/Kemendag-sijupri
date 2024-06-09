<?php

namespace App\Http\Livewire\Siap;

use App\Enums\RoleCode;
use App\Enums\UserStatus;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Maintenance\Service\KabKotaService;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use App\Http\Controllers\Maintenance\Service\TipeInstansiService;
use App\Http\Controllers\Siap\Service\RegistrationService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SiapRegistration extends Component
{
    public $userContext, $unitKerjaContext;
    public $tipeInstansi, $provinsi, $kabKota, $unitKerja;
    public $data = [];
    public $request = [
        'provinsi_id' => null,
        'tipe_instansi_code' => null,
    ];

    public function mount(TipeInstansiService $tipeInstansi, ProvinsiService $provinsi, KabKotaService $kabKota, UnitKerjaService $unitKerja)
    {
        $this->tipeInstansi = $tipeInstansi;
        $this->provinsi = $provinsi;
        $this->kabKota = $kabKota;
        $this->unitKerja = $unitKerja;
    }

    public function render()
    {
        $userContext = auth()->user();
        $unitKerjaContext = $userContext->unitKerja;

        $this->data['title'] = "Jabatan Fungsional";
        $this->data['tipeInstansi'] = $this->tipeInstansi->findById($unitKerjaContext->tipe_instansi_code);
        $this->data['provinsi'] = $unitKerjaContext->provinsi;
        $this->data['kabupaten'] = $unitKerjaContext->kabupaten;
        $this->data['kota'] = $unitKerjaContext->kota;
        $this->data['unitKerja'] = $unitKerjaContext;
        return view('livewire.siap.siap-registration-jf');
    }

    public function store(RegistrationService $registration)
    {
        $userContext = auth()->user();

        if ($userContext->role_code == RoleCode::SUPER_ADMIN) {
            $this->validationCheck();
            $this->request['role_code'] = RoleCode::ADMIN_INSTANSI;
        } else if ($userContext->role_code == RoleCode::ADMIN_INSTANSI) {
            $this->adminOpdCheck();
            $this->request['role_code'] = RoleCode::ADMIN_SIAP;
            $this->request['tipe_instansi_code'] = $userContext->tipe_instansi_code;
        } else if ($userContext->role_code == RoleCode::ADMIN_SIAP) {
            $this->userJFCheck();
            $this->request['role_code'] = RoleCode::USER;
            $this->request['tipe_instansi_code'] = $userContext->tipe_instansi_code;
            $this->request['unit_kerja_id'] = $userContext->unit_kerja_id;
            $this->request['user_status'] = UserStatus::NOT_ACTIVE;
            $this->request['tipe_instansi_code'] = $userContext->tipe_instansi_code;
        }

        $this->request['password'] = $this->request['nip'];
        $registration->register($this->request);

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);

        redirect()->route('siap.registration');
    }

    private function validationCheck()
    {
        $this->validate([
            "request.tipe_instansi_code" => 'required',
            "request.nip" => 'required|string|size:18|regex:/^[0-9]+$/',
            "request.name" => 'required',
        ]);

        if ($this->request['tipe_instansi_code'] == 'provinsi') {
            $this->validate([
                "request.provinsi_id" => 'required',
                "request.unit_kerja_nama" => 'required',
            ]);
        } else if ($this->request['tipe_instansi_code'] == 'kabupaten') {
            $this->validate([
                "request.provinsi_id" => 'required',
                "request.kabupaten_id" => 'required',
                "request.unit_kerja_nama" => 'required',
            ]);
        } else if ($this->request['tipe_instansi_code'] == 'kota') {
            $this->validate([
                "request.provinsi_id" => 'required',
                "request.kota_id" => 'required',
                "request.unit_kerja_nama" => 'required',
            ]);
        } else if ($this->request['tipe_instansi_code'] == 'kementerian_lembaga') {
            $this->validate([
                "request.unit_kerja_id" => 'required',
            ]);
        }
    }

    private function adminOpdCheck()
    {
        $this->validate([
            "request.unit_kerja_id" => 'required',
            "request.nip" => 'required|string|size:18|regex:/^[0-9]+$/',
            "request.name" => 'required',
        ]);
    }

    private function userJFCheck()
    {
        $this->validate([
            "request.nip" => 'required|string|size:18|regex:/^[0-9]+$/',
            "request.name" => 'required',
        ]);
    }

    public function error($exception, $componentId, $action)
    {
        Log::error("unknowns error : {$exception->getMessage()}");
        if ($exception instanceof BusinessException) {
            session()->flash('response', [
                'title' => 'Error',
                'message' => $exception->getMessage(),
                'icon' => 'error',
            ]);
        } else {
            session()->flash('response', [
                'title' => 'Error',
                'message' => 'something went wrong',
                'icon' => 'error',
            ]);
        }
    }
}
