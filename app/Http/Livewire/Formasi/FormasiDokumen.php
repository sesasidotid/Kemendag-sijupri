<?php

namespace App\Http\Livewire\Formasi;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Formasi\Service\FormasiDocumentService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormasiDokumen extends Component
{
    use WithFileUploads;

    public $data = [];
    public $request = [];

    public function render(FormasiDocumentService $formasiDocument)
    {
        $formasiDocument = $formasiDocument->getDokumenFormasi();
        return view('livewire.formasi.formasi-dokumen', compact('formasiDocument'));
    }

    public function updatedRequest($file, $file_param)
    {
        $this->validate([
            'request.' . $file_param => 'required|mimes:pdf|max:2048',
        ]);

        $formasiDocument = new FormasiDocumentService();
        $formasiDocument = $formasiDocument->getDokumenFormasi();
        $formasiDocument->saveAndUpload($file, $file_param);
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
