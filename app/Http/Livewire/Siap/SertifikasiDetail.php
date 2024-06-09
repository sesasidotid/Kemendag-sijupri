<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserSertifikasiService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SertifikasiDetail extends Component
{
    public $userSertifikasi;
    public $request = [];

    public function mount(UserSertifikasiService $userSertifikasi)
    {
        $this->userSertifikasi = $userSertifikasi;
    }

    public function render()
    {
        $userContext = auth()->user();
        $sertifikasiList = $this->userSertifikasi->findByNip($userContext->nip);
        return view('livewire.siap.sertifikasi-detail', compact(
            'sertifikasiList'
        ));
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
