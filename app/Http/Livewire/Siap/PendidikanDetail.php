<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\UserPendidikanService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PendidikanDetail extends Component
{

    public $userPendidikan;
    public $request = [];

    public function mount(UserPendidikanService $userPendidikan)
    {
        $this->userPendidikan = $userPendidikan;
    }

    public function render()
    {
        $userContext = auth()->user();
        $pendidikanList = $this->userPendidikan->findByNip($userContext->nip);
        return view('livewire.siap.pendidikan-detail', compact('pendidikanList'));
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
