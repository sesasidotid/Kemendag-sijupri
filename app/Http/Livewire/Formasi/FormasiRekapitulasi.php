<?php

namespace App\Http\Livewire\Formasi;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Formasi\Service\FormasiResultService;
use App\Http\Controllers\Formasi\Service\FormasiService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormasiRekapitulasi extends Component
{
    private $jabatan_code;
    private $formasi, $formasiResult;

    public $data = [];

    public function mount($jabatan_code, FormasiService $formasi)
    {
        $this->jabatan_code = $jabatan_code;
        $this->formasi = $formasi;
    }

    public function render()
    {
        $formasi = $this->formasi->generateFormasi($this->jabatan_code);
        return view('livewire.formasi.formasi-rekapitulasi', compact(
            'formasi',
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
