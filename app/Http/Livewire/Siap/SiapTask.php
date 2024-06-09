<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SiapTask extends Component
{
    public function render()
    {
        return view('livewire.siap.siap-task');
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
