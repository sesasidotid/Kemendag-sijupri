<?php

namespace App\Http\Livewire\Formasi;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormasiTimeline extends Component
{
    public function render()
    {
        return view('livewire.formasi.formasi-timeline');
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
