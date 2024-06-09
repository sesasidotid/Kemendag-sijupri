<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Throwable;

class UserDetail extends Component
{

    protected $user;
    protected $unitKerja;
    public $request = [];

    public function mount()
    {
        $userContext = auth()->user();
        $userDetail = $userContext->userDetail ?? null;

        if ($userDetail) {
            $this->request['nik'] = $userDetail->nik;
            $this->request['no_hp'] = $userDetail->no_hp;
            $this->request['email'] = $userDetail->email;
            $this->request['jenis_kelamin'] = $userDetail->jenis_kelamin;
            $this->request['tempat_lahir'] = $userDetail->tempat_lahir;
            $this->request['tanggal_lahir'] = \Carbon\Carbon::parse($userDetail->tanggal_lahir)->format('Y-m-d');
        }
    }

    public function render()
    {
        $userContext = auth()->user();
        $user = $userContext;
        $unitKerja = $userContext->unitKerja;
        return view('livewire.siap.user-detail', compact('unitKerja', 'user'));
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
