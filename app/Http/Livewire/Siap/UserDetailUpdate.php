<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class UserDetailUpdate extends Component
{
    use WithFileUploads;

    protected $user;
    protected $unitKerja;
    public $request = [];

    public function mount()
    {
        $userContext = auth()->user();
        $userDetail = $userContext->userDetail ?? null;

        if ($userDetail) {
            $this->request['nik'] = $userDetail->nik;
            $this->request['no_hp'] = $userDetail->no_hp;
            $this->request['email'] = $userDetail->email;
            $this->request['jenis_kelamin'] = $userDetail->jenis_kelamin;
            $this->request['tempat_lahir'] = $userDetail->tempat_lahir;
            $this->request['tanggal_lahir'] = \Carbon\Carbon::parse($userDetail->tanggal_lahir)->format('Y-m-d');
        }
    }

    public function render()
    {
        $userContext = auth()->user();
        $user = $userContext;
        $unitKerja = $userContext->unitKerja;
        // die(var_dump($userContext));
        return view('livewire.siap.user-detail-update', compact('unitKerja', 'user'));
        // return view('livewire.siap.instansi-detail-update', compact('unitKerja', 'user'));
        // return view('livewire.siap.unitkerja-detail-update', compact('unitKerja', 'user'));
    }

    public function store(ProfileService $profile)
    {
        $this->validate([
            "request.nik" => 'required',
            "request.jenis_kelamin" => 'required',
            "request.no_hp" => 'required|min:10|max:15',
            "request.email" => 'required|email',
            "request.tempat_lahir" => 'required',
            "request.tanggal_lahir" => 'required',
            "request.file_ktp" => 'required|mimes:pdf|max:2048',
        ]);
        try {
            $profile->updateUserDetail($this->request);

            Session::flash('status', 1);
            $this->request = [];
        } catch (Throwable $th) {
            Session::flash('status',    0);
            Session::flash('message', $th);
        }

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);

        return redirect()->route('/profile');
    }

    public function updatedRequest($value, $params)
    {
        if ($params === 'file_ktp') {
            $this->emit('fileUploading');
            $this->emit('fileUploaded');
        }
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
