<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserSertifikasiService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class SertifikasiUpdate extends Component
{
    use WithFileUploads;
    public $userSertifikasi;
    public $request = [];

    public function mount(UserSertifikasiService $userSertifikasi)
    {
        $this->userSertifikasi = $userSertifikasi;
    }

    public function render()
    {
        $userContext = auth()->user();
        $sertifikasiList = $this->userSertifikasi->findByNip($userContext->nip);
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.siap.sertifikasi-update', compact(
            'sertifikasiList'
        ));
    }

    public function store(ProfileService $profile)
    {
        $this->validate([
            "request.kategori" => 'required',
            "request.nomor_sk" => 'required',
            "request.tanggal_sk" => 'required',
            "request.file_doc_sk" => 'required:mimes:pdf|max:2048',
        ]);
        if ($this->request['kategori'] !== "Pegawai Berhak") {
            $this->validate([
                "request.wilayah_kerja" => 'required',
                "request.berlaku_mulai" => 'required',
                "request.berlaku_sampai" => 'required',
                "request.uu_kawalan" => 'required',
                "request.file_ktp_ppns" => 'required:mimes:pdf|max:2048',
            ]);
        }

        $profile->updateUserSertifikasi($this->request);
        $this->request = [];

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);
    }

    public function updatedRequest($value, $params)
    {
        if (in_array($params, (['file_doc_sk', 'file_ktp_ppns']))) {
            $this->emit('fileUploading');
            $this->emit('fileUploaded');
        }
    }

    public function delete($id) {
        $userSertifikasi = new UserSertifikasiService();
        $userSertifikasi = $userSertifikasi->findById($id);
        $userSertifikasi->customDelete();

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
