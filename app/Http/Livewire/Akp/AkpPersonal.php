<?php

namespace App\Http\Livewire\Akp;

use App\Exceptions\BusinessException;
use Livewire\Component;
use App\Http\Controllers\AKP\Service\AkpInstrumenService;
use App\Http\Controllers\AKP\Service\AkpService;
use Illuminate\Support\Facades\Log;

class AkpPersonal extends Component
{
    public $akp_id = null;
    protected $data = [];
    public $request = [];
    public $akpMatrix = [];
    public $akp = [];
    private $akpInstrumen;
    public $page = 1;
    public $isFailed = false;

    public function mount($akp_id, AkpInstrumenService $akpInstrumen, AkpService $akp)
    {
        $this->akp_id = $akp_id;

        $userContext = auth()->user();
        $userDetail = $userContext->userDetail;

        $akp = $akp->findById($akp_id);
        foreach ($akp->akpMatrix as $key => $value) {
            $this->akpMatrix[$value->akp_pertanyaan_id]['atasan'] = $value->atasan;
            $this->akpMatrix[$value->akp_pertanyaan_id]['rekan'] = $value->rekan;
        }

        $akpInstrumen = $akpInstrumen->findByJenjangCodeAndJabatanCode($userContext->jabatan->jenjang_code, $userContext->jabatan->jabatan_code);
        foreach ($akpInstrumen->akpKategoriPertanyaan as $key => $kategori) {
            foreach ($kategori->akpPertanyaan as $key => $pertanyaan) {
                $this->request[$pertanyaan->id]['ybs'] = 1;
                $this->request[$pertanyaan->id]['penugasan'] = 1;
                $this->request[$pertanyaan->id]['materi'] = 1;
                $this->request[$pertanyaan->id]['informasi'] = 1;
                $this->request[$pertanyaan->id]['waktu'] = 1;
                $this->request[$pertanyaan->id]['kesulitan'] = 1;
                $this->request[$pertanyaan->id]['kualitas'] = 1;
                $this->request[$pertanyaan->id]['pengaruh'] = 1;
            }
        }
    }

    public function render(AkpInstrumenService $akpInstrumen)
    {
        $userContext = auth()->user();
        $userDetail = $userContext->userDetail;
        $this->akpInstrumen = $akpInstrumen->findByJenjangCodeAndJabatanCode($userContext->jabatan->jenjang_code, $userContext->jabatan->jabatan_code);
        return view('livewire.akp.akp-personal', [
            'akpInstrumen' => $this->akpInstrumen,
            'user' => $userContext
        ]);
    }

    public function store(AkpService $akp)
    {
        $userContext = auth()->user();
        $akpNew['nip'] = $userContext->nip;
        $akpNew['pangkat_id'] = $userContext->pangkat->pangkat_id;
        $akpNew['jabatan_code'] = $userContext->jabatan->jabatan_code;
        $akpNew['nama_jabatan'] = $userContext->jabatan->jabatan->name;
        $akpNew['unit_kerja'] = $userContext->unitKerja->name;

        $akp = $akp->findById($this->akp_id);
        $akp->saveUpdateScoreWithMatrixAKP($akpNew, $this->request);

        return redirect()->to(route('/akp/review'));
    }

    public function nextPage($pertanyaanId)
    {
        $score = $this->request[$pertanyaanId]['ybs'] + $this->akpMatrix[$pertanyaanId]['atasan'] + $this->akpMatrix[$pertanyaanId]['rekan'];
        if ($score < 7) {
            $this->isFailed = true;
        } else {
            $this->isFailed = false;
            $this->page++;
        }
    }

    public function nextPageMatrix($pertanyaanId)
    {
        $this->isFailed = false;
        $this->page++;
    }

    public function prefPage()
    {
        if ($this->isFailed)
            $this->isFailed = false;
        else
            $this->page--;
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
