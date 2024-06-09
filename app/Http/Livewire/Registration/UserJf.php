<?php

namespace App\Http\Livewire\Registration;

use App\Enums\RoleCode;
use App\Enums\TipeInstansi;
use App\Enums\UserStatus;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\RegistrationService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Throwable;

class UserJf extends Component
{
    public $unitkerja, $provinsi, $kabKota, $instansi;
    public $data = [];
    public $request = [];

    public function mount()
    {
    }

    public function render()
    {
        $userContext = auth()->user();
        $unitKerjaData = $userContext->unitKerja;
        $provinsiData = $unitKerjaData->provinsi;
        $kabupatenData = $unitKerjaData->kabupaten;
        $kotaData = $unitKerjaData->kota;

        return view('livewire.registration.user-jf', compact(
            'unitKerjaData',
            'provinsiData',
            'kabupatenData',
            'kotaData'
        ));
    }

    public function store(RegistrationService $registration)
    {

        $userContext = auth()->user();
        $this->validate([
            "request.nip" => 'required|string|size:18|regex:/^[0-9]+$/',
            "request.name" => 'required',
        ]);

        $this->request['tipe_instansi_code'] = $userContext->tipe_instansi_code;
        if ($this->request['tipe_instansi_code'] == TipeInstansi::PUSBIN) {
            $this->request['role_code'] = RoleCode::USER_INTERNAL;
        } else {
            $this->request['role_code'] = RoleCode::USER_EXTERNAL;
        }

        $this->request['instansi_id'] = $userContext->instansi_id;
        $this->request['unit_kerja_id'] = $userContext->unit_kerja_id;
        $this->request['user_status'] = UserStatus::NOT_ACTIVE;
        $this->request['tipe_instansi_code'] = $userContext->tipe_instansi_code;
        $this->request['app_code'] = "USER";

        $this->request['password'] = $this->request['nip'];
        try {
            $registration->register($this->request);
            session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
            return redirect()->route('/user/user_jf');
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
