<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserKompetensiService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class KompetensiDetail extends Component
{
    public $userKompetensi;
    public $request = [];

    public function mount(UserKompetensiService $userKompetensi)
    {
        $this->userKompetensi = $userKompetensi;
    }

    public function render()
    {
        $userContext = auth()->user();
        $kompetensiList = $this->userKompetensi->findByNip($userContext->nip);
        return view('livewire.siap.kompetensi-detail', compact(
            'kompetensiList'
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
