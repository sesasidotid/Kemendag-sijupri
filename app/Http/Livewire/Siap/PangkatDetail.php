<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Maintenance\Service\PangkatService;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserPangkatService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PangkatDetail extends Component
{
    public $userPangkat, $pangkat;
    public $request = [];

    public function mount(UserPangkatService $userPangkat, PangkatService $pangkat)
    {
        $this->userPangkat = $userPangkat;
        $this->pangkat = $pangkat;
    }

    public function render()
    {
        $userContext = auth()->user();

        $userPangkatList = $this->userPangkat->findByNip($userContext->nip);
        $pangkatList = $this->pangkat->findAll();

        return view('livewire.siap.pangkat-detail', compact(
            'userPangkatList',
            'pangkatList',
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
