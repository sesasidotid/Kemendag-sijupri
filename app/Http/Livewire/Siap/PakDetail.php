<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserPakService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PakDetail extends Component
{
    public $pak;
    public $request = [];

    public function mount(UserPakService $pak)
    {
        $this->pak = $pak;
    }

    public function render()
    {
        $userContext = auth()->user();

        $userJabatanList = $this->pak->findByNip($userContext->nip);
        return view('livewire.siap.pak-detail', compact(
            'userJabatanList',
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
