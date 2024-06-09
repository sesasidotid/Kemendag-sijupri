<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Maintenance\Service\JabatanService;
use App\Http\Controllers\Maintenance\Service\JenjangService;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserJabatanService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class JabatanUpdate extends Component
{
    use WithFileUploads;

    public $userJabatan, $jabatan, $jenjang;
    public $request = [];

    public function mount(UserJabatanService $userJabatan, JabatanService $jabatan, JenjangService $jenjang)
    {
        $this->userJabatan = $userJabatan;
        $this->jabatan = $jabatan;
        $this->jenjang = $jenjang;
    }

    public function render()
    {
        $userContext = auth()->user();

        $userJabatanList = $this->userJabatan->findByNip($userContext->nip);
        $jabatanList = $this->jabatan->findAll();
        $jenjangList = $this->jenjang->findAll();
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.siap.jabatan-update', compact(
            'userJabatanList',
            'jabatanList',
            'jenjangList'
        ));
    }

    public function store(ProfileService $profile)
    {
        $this->validate([
            "request.jabatan_code" => "required",
            "request.jenjang_code" => "required",
            "request.tmt" => 'required',
            "request.file_sk_jabatan" => 'required|mimes:pdf|max:2048',
        ]);
        $this->request['name'] = $this->jabatan->findById($this->request['jabatan_code'])->name;

        $profile->updateUserJabatan($this->request);
        $this->request = [];

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
    }

    public function updatedRequest($value, $params)
    {
        if (in_array($params, (['file_sk_jabatan']))) {
            $this->emit('fileUploading');
            $this->emit('fileUploaded');
        }
    }

    public function delete($id) {
        $userJabatan = new UserJabatanService();
        $userJabatan = $userJabatan->findById($id);
        $userJabatan->customDelete();

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
