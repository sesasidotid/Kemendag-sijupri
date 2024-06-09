<?php

namespace App\Http\Livewire\Registration;

use App\Enums\RoleCode;
use App\Enums\TipeInstansi;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\RegistrationService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Throwable;

class AdminPengelola extends Component
{
    public $unitkerja;
    public $data = [];
    public $request = [];

    public function mount(UnitKerjaService $unitkerja)
    {
        $this->unitkerja = $unitkerja;
    }

    public function render()
    {
        $userContext = auth()->user();

        $unitKerja = $userContext->unitKerja;
        $instansi = $userContext->instansi;
        $unitKerjaList = $this->unitkerja->findByTipeInstansiCodeAndInstansiId($userContext->tipe_instansi_code, $userContext->instansi_id);
        return view('livewire.registration.admin-pengelola', compact(
            'instansi',
            'unitKerja',
            'unitKerjaList'
        ));
    }

    public function store(RegistrationService $registration)
    {
        $userContext = auth()->user();
        $this->validate([
            "request.unit_kerja_id" => 'required',
            "request.nip" => 'required|string|size:18|regex:/^[0-9]+$/',
            "request.name" => 'required',
        ]);

        $this->request['tipe_instansi_code'] = $userContext->tipe_instansi_code;
        if ($this->request['tipe_instansi_code'] == TipeInstansi::PUSBIN) {
            $this->request['role_code'] = RoleCode::SES;
        } else if ($this->request['tipe_instansi_code'] == TipeInstansi::KL) {
            $this->request['role_code'] = RoleCode::UNIT_KERJA;
        } else {
            $this->request['role_code'] = RoleCode::OPD;
        }

        $this->request['instansi_id'] = $userContext->instansi_id;
        $this->request['password'] = $this->request['nip'];
        $this->request['app_code'] = "USER";
        try {
            $registration->register($this->request);
            session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
            return redirect()->route('/user/admin_unit_kerja_instansi_daerah');
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
