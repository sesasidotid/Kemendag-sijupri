<?php

namespace App\Http\Livewire\Siap;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Maintenance\Service\JabatanService;
use App\Http\Controllers\Maintenance\Service\JenjangService;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserJabatanService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class JabatanDetail extends Component
{
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
        return view('livewire.siap.jabatan-detail', compact(
            'userJabatanList',
            'jabatanList',
            'jenjangList'
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
