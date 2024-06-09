<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserPendidikanService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class PendidikanUpdate extends Component
{
    use WithFileUploads;

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
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.siap.pendidikan-update', compact('pendidikanList'));
    }

    public function store(ProfileService $profile)
    {
        $this->validate([
            "request.level" => 'required',
            "request.instansi_pendidikan" => 'required',
            "request.jurusan" => 'required',
            "request.bulan_kelulusan" => 'required',
            "request.file_ijazah" => 'required|mimes:pdf|max:2048',
        ]);
        $this->request['bulan_kelulusan'] = $this->request['bulan_kelulusan'] . "-01";
        $profile->updateUserPendidikan($this->request);
        $this->request = [];

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
    }

    public function updatedRequest($value, $params)
    {
        if (in_array($params, (['file_ijazah']))) {
            $this->emit('fileUploading');
            $this->emit('fileUploaded');
        }
    }

    public function delete($id) {
        $userPendidikan = new UserPendidikanService();
        $userPendidikan = $userPendidikan->findById($id);
        $userPendidikan->customDelete();

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
