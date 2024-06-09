<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserKompetensiService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class KompetensiUpdate extends Component
{
    use WithFileUploads;
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
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.siap.kompetensi-update', compact(
            'kompetensiList'
        ));
    }

    public function store(ProfileService $profile)
    {

        $this->validate([
            "request.name" => 'required',
            "request.kategori" => 'required',
            "request.tgl_mulai" => 'required',
            "request.tgl_selesai" => 'required',
            "request.tgl_sertifikat" => 'required',
            "request.file_sertifikat" => 'required|mimes:pdf|max:2048',
        ]);

        $profile->updateUserKompetensi($this->request);
        $this->request = [];

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
    }

    public function updatedRequest($value, $params)
    {
        if (in_array($params, (['file_sertifikat']))) {
            $this->emit('fileUploading');
            $this->emit('fileUploaded');
        }
    }

    public function delete($id) {
        $userKompetensi = new UserKompetensiService();
        $userKompetensi = $userKompetensi->findById($id);
        $userKompetensi->customDelete();

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
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
