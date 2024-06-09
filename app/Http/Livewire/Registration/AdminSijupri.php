<?php

namespace App\Http\Livewire\Registration;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\RegistrationService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Throwable;

class AdminSijupri extends Component
{
    public $data = [];
    public $request = [];
    public function render()
    {
        return view('livewire.registration.admin-sijupri');
    }

    public function store(RegistrationService $registration)
    {
        $userContext = auth()->user();
        $this->validate([
            "request.nip" => 'required|string|size:18|regex:/^[0-9]+$/',
            "request.name" => 'required',
            "request.role_code" => 'required',
        ]);

        $this->request['instansi_id'] = $userContext->instansi_id;
        $this->request['password'] = $this->request['nip'];
        $this->request['app_code'] = "PUSBIN";
        try {
            $registration->register($this->request);
            session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
            return redirect()->route('/security/user');
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
