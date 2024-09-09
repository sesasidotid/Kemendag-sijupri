<?php

namespace App\Http\Livewire\Registration;

use App\Enums\RoleCode;
use App\Enums\TipeInstansi;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Maintenance\Service\KabKotaService;
use App\Http\Controllers\Maintenance\Service\ProvinsiService;
use App\Http\Controllers\Maintenance\Service\TipeInstansiService;
use App\Http\Controllers\Siap\Service\InstansiService;
use App\Http\Controllers\Siap\Service\RegistrationService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Throwable;

class AdminInstansi extends Component
{
    public $tipeInstansi, $provinsi, $kabKota, $instansi;
    public $data = [];
    public $request = [
        'provinsi_id' => null,
        'kabupaten_id' => null,
        'tipe_instansi_code' => null,
    ];

    public $provinsiList = [];
    public $kabupatenList = [];
    public $kotaList = [];
    public $instansiList = [];

    public function mount(TipeInstansiService $tipeInstansi, ProvinsiService $provinsi, KabKotaService $kabKota, InstansiService $instansi)
    {
        $this->tipeInstansi = $tipeInstansi;
        $this->instansi = $instansi;
        $this->provinsi = $provinsi;
        $this->kabKota = $kabKota;
    }

    public function render()
    {
        if (count($this->provinsiList) == 0) {
            $this->provinsiList = $this->provinsi->findAll();
        }
        if (count($this->kabupatenList) == 0) {
            $this->kabupatenList = $this->kabKota->findByType('kabupaten');
        }
        if (count($this->kotaList) == 0) {
            $this->kotaList = $this->kabKota->findByType('kota');
        }
        if (count($this->instansiList) == 0) {
            $this->instansiList = $this->instansi->findByTipeInstansi($this->request['tipe_instansi_code']);
        }
        return view('livewire.registration.admin-instansi');
    }

    public function updatedRequestProvinsiId($provinsiId)
    {
        if ($this->request['tipe_instansi_code'] == "kabupaten") {
            $this->kabupatenList = $this->kabKota->findByTypeAndProvinsiId('kabupaten', $provinsiId);
        } else if ($this->request['tipe_instansi_code'] == TipeInstansi::KABUPATEN) {
            $this->kotaList = $this->kabKota->findByTypeAndProvinsiId('kota', $provinsiId);
        }
    }

    public function store()
    {
        $validation = [
            "request.tipe_instansi_code" => 'required',
            "request.nip" => 'required|string|size:18|regex:/^[0-9]+$/',
            "request.name" => 'required'
        ];

        if ($this->request['tipe_instansi_code'] == TipeInstansi::PROVINSI) {
            $validation['request.provinsi_id'] = 'required';
            $validation['request.instansi_initials'] = 'required';
            if (isset($this->request['request.kabupaten_id']))
                $this->request['request.kabupaten_id'] = null;
            if (isset($this->request['request.kota_id']))
                $this->request['request.kota_id'] = null;
            if (isset($this->request['request.instansi_id']))
                $this->request['request.instansi_id'] = null;
        } else if ($this->request['tipe_instansi_code'] == TipeInstansi::KABUPATEN) {
            $validation['request.provinsi_id'] = 'required';
            $validation['request.kabupaten_id'] = 'required';
            $validation['request.instansi_initials'] = 'required';
            if (isset($this->request['request.kota_id']))
                $this->request['request.kota_id'] = null;
            if (isset($this->request['request.instansi_id']))
                $this->request['request.instansi_id'] = null;
        } else if ($this->request['tipe_instansi_code'] == TipeInstansi::KOTA) {
            $validation['request.provinsi_id'] = 'required';
            $validation['request.kota_id'] = 'required';
            $validation['request.instansi_initials'] = 'required';
            if (isset($this->request['request.kabupaten_id']))
                $this->request['request.kabupaten_id'] = null;
            if (isset($this->request['request.instansi_id']))
                $this->request['request.instansi_id'] = null;
        } else {
            $validation['request.instansi_id'] = 'required';
            if (isset($this->request['request.provinsi_id']))
                $this->request['request.provinsi_id'] = null;
            if (isset($this->request['request.kota_id']))
                $this->request['request.kota_id'] = null;
            if (isset($this->request['request.instansi_initials']))
                $this->request['request.instansi_initials'] = null;
            if (isset($this->request['request.kabupaten_id']))
                $this->request['request.kabupaten_id'] = null;
        }
        $this->validate($validation);

        if ($this->request['tipe_instansi_code'] == TipeInstansi::PUSBIN) {
            $this->request['role_code'] = RoleCode::PUSBIN;
        } else if ($this->request['tipe_instansi_code'] == TipeInstansi::KL) {
            $this->request['role_code'] = RoleCode::UNIT_PEMBINA;
        } else {
            $this->request['role_code'] = RoleCode::BKPSDM_BKD;
        }

        $this->request['password'] = $this->request['nip'];
        $this->request['app_code'] = "USER";

        try {
            $registration = new RegistrationService();
            $registration->register($this->request);
            session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
            return redirect()->route('/user/admin_instansi');
        } catch (Exception $e) {
            $this->error($e, "", "");
        }
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
