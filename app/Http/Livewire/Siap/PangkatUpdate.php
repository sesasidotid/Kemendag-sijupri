<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Maintenance\Service\PangkatService;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserPangkatService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class PangkatUpdate extends Component
{
    use WithFileUploads;

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
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.siap.pangkat-update', compact(
            'userPangkatList',
            'pangkatList',
        ));
    }

    public function store(ProfileService $profile)
    {
        $this->validate([
            "request.tmt" => 'required',
            "request.pangkat_id" => 'required',
            "request.file_sk_pangkat" => 'required|mimes:pdf|max:2048',
        ]);

        $profile->updateUserPangkat($this->request);
        $this->request = [];

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
    }

    public function updatedRequest($value, $params)
    {
        if (in_array($params, (['file_sk_pangkat']))) {
            $this->emit('fileUploading');
            $this->emit('fileUploaded');
        }
    }

    public function delete($id) {
        $userPangkat = new UserPangkatService();
        $userPangkat = $userPangkat->findById($id);
        $userPangkat->customDelete();

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
