<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserPakService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class PakUpdate extends Component
{
    use WithFileUploads;

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
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.siap.pak-update', compact(
            'userJabatanList',
        ));
    }

    public function store(ProfileService $profile)
    {
        $this->validate([
            "request.periode" => 'required',
            "request.tgl_mulai" => 'required',
            "request.tgl_selesai" => 'required',
            "request.nilai_kinerja" => 'required',
            "request.nilai_perilaku" => 'required',
            "request.predikat" => 'required',
            "request.file_doc_ak" => 'required|mimes:pdf|max:2048',
            "request.file_hasil_eval" => 'required|mimes:pdf|max:2048',
            "request.file_akumulasi_ak" => 'required|mimes:pdf|max:2048',

        ]);
        $profile->updateUserPak($this->request);
        $this->request = [];

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
    }

    public function updatedRequest($value, $params)
    {
        if (in_array($params, (['file_doc_ak', 'file_hasil_eval', 'file_akumulasi_ak']))) {
            $this->emit('fileUploading');
            $this->emit('fileUploaded');
        }
    }

    public function delete($id) {
        $userPak = new UserPakService();
        $userPak = $userPak->findById($id);
        $userPak->customDelete();

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
