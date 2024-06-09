<?php

namespace App\Http\Livewire\Siap;

use App\Enums\TaskStatus;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Siap\Service\ProfileService;
use App\Http\Controllers\Siap\Service\UserUkomService;
use App\Http\Controllers\Ukom\Service\UkomPeriodeService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class UkomUpdate extends Component
{
    use WithFileUploads;

    public $request = [];
    protected  $userNip;

    public function mount($userNip)
    {
        $this->userNip =$userNip;

    }
    public function render(UserUkomService $userUkom)
    {
        $ukomList = $userUkom->findByNip(session()->get('nip'));
        $this->dispatchBrowserEvent('contentChanged');
        return view('livewire.siap.ukom-update', compact(
            'ukomList'
        ));
    }
    public function store(ProfileService $profile )
    {


        $nip = session()->get('nip') ;

        $this->validate([
            "request.ukom.periode" => 'required',
            "request.ukom.jenis" => 'required',
            "request.ukom.nilai_akhir" => 'required',
            "request.mansoskul.integritas" => 'required',
            "request.mansoskul.kerjasama" => 'required',
            "request.mansoskul.komunikasi" => 'required',
            "request.mansoskul.orientasi_hasil" => 'required',
            "request.mansoskul.pelayanan_publik" => 'required',
            "request.mansoskul.pengembangan_diri_orang_lain" => 'required',
            "request.mansoskul.mengelola_perubahan" => 'required',
            "request.mansoskul.pengambilan_keputusan" => 'required',
            "request.mansoskul.perekat_bangsa" => 'required',
            "request.mansoskul.jpm" => 'required',
            "request.teknis.cat" => 'required',
            "request.teknis.wawancara" => 'required',
            "request.teknis.praktik" => 'required',
            "request.teknis.makala" => 'required',
            "request.teknis.nilai_bobot" => 'required'

        ]);
        // dd($this->request);

        $this->request['ukom']['periode'] = $this->request['ukom']['periode'] . "-01";
        $profile->updateUserUkom($this->request['ukom'], $this->request['mansoskul'], $this->request['teknis'], $nip);
        session()->flash('status', 1) ;
        $this->request = [];

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);

    }
    public function cekPeriode()
    {
        $periode = new UkomPeriodeService();
        $periode = $periode->cekPeriode(TaskStatus::APPROVE);
        return $periode;
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
