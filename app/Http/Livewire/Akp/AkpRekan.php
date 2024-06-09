<?php

namespace App\Http\Livewire\Akp;

use App\Enums\AkpStatus;
use App\Exceptions\BusinessException;
use Livewire\Component;
use App\Http\Controllers\AKP\Service\AkpInstrumenService;
use App\Http\Controllers\AKP\Service\AkpMatrixService;
use App\Http\Controllers\AKP\Service\AkpService;
use App\Http\Controllers\Security\Service\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AkpRekan extends Component
{
    public $request = [];
    public $temp = [];
    public $nip;

    public function mount($nip = null)
    {
        try {
            $this->nip = $nip;
            $user = new UserService();
            $akpInstrumen = new AkpInstrumenService();

            $user = $user->findByNip($this->nip);
            $userDetail = $user->userDetail;
            $akpInstrumen = $akpInstrumen->findByJenjangCodeAndJabatanCode($user->jabatan->jenjang_code, $user->jabatan->jabatan_code);

            if ($akpInstrumen) {
                foreach ($akpInstrumen->AkpKategoriPertanyaan as $key => $akpKategoriPertanyaan) {
                    foreach ($akpKategoriPertanyaan->akpPertanyaan as $key2 => $akpPertanyaan) {
                        $this->request[$akpPertanyaan->id] = 1;
                    }
                }
            } else {
                return view('akp.review_failed', [
                    'message' => "pejabatan functional tidak memiliki instrumen akp"
                ]);
            }
        } catch (\Throwable $th) {
            return view('akp.review_failed', [
                'message' => "terjadi kesalahan, mohon menghubungi pihak yang bersangkutan"
            ]);
        }
    }

    public function render(UserService $user, AkpInstrumenService $akpInstrumen)
    {
        try {
            $user = $user->findByNip($this->nip);
            $userDetail = $user->userDetail;
            $akpInstrumen = $akpInstrumen->findByJenjangCodeAndJabatanCode($user->jabatan->jenjang_code, $user->jabatan->jabatan_code);
            if (!$akpInstrumen) {
                return view('akp.review_failed', [
                    'message' => "pejabatan functional tidak memiliki instrumen akp"
                ]);
            } else {
                return view('livewire.akp.akp-rekan', compact(
                    'user',
                    'akpInstrumen'
                ));
            }
        } catch (\Throwable $th) {
            return view('akp.review_failed', [
                'message' => "terjadi kesalahan, mohon menghubungi pihak yang bersangkutan"
            ]);
        }
    }

    public function store(AkpService $akp, UserService $user, AkpInstrumenService $akpInstrumen, AkpMatrixService $akpMatrix)
    {
        try {
            DB::transaction(function () use ($akp, $user, $akpInstrumen, $akpMatrix) {
                $user = $user->findByNip($this->nip);
                $userDetail = $user->userDetail;
                $akpInstrumen = $akpInstrumen->findByJenjangCodeAndJabatanCode($user->jabatan->jenjang_code, $user->jabatan->jabatan_code);

                $this->temp['jenjang_code'] = $user->jabatan->jenjang_code;
                $this->temp['jabatan_code'] = $user->jabatan->jabatan_code;
                $this->temp['pangkat_id'] = $user->pangkat->pangkat_id;
                $this->temp['akp_instrumen_id'] = $akpInstrumen->id;
                $this->temp['nip'] = $this->nip;

                $validation = [];
                foreach ($akpInstrumen->AkpKategoriPertanyaan as $akpKategori) {
                    foreach ($akpKategori->akpPertanyaan as $value) {
                        $validation['request.' . $value->id] = 'required';
                    }
                }
                $this->validate($validation);

                $akp = $akp->generateAkp($this->temp, AkpStatus::REKAN_REVIEWED);
                $akpMatrix->customSaveAll($this->request, $akp->id, "rekan");
            });

            return redirect()->to(route('/akp/review/selesai'));
        } catch (\Throwable $th) {
            return redirect()->to(route('/akp/review/failed', ['message' => 'terjadi kesalahan, mohon menghubungi pihak yang bersangkutan']));
        }
    }

    public function temp(AkpService $akp, UserService $user, AkpInstrumenService $akpInstrumen)
    {
        $this->validate(['temp.nip' => 'required']);

        try {
            $user = $user->findByNip($this->temp['nip']);
            if ($user) {
                $userDetail = $user->userDetail;
                $akpInstrumen = $akpInstrumen->findByJenjangCodeAndJabatanCode($user->jabatan->jenjang_code, $user->jabatan->jabatan_code);

                $this->temp['jenjang_code'] = $user->jabatan->jenjang_code;
                $this->temp['jabatan_code'] = $user->jabatan->jabatan_code;
                $this->temp['pangkat_id'] = $user->pangkat->pangkat_id;
                $this->temp['akp_instrumen_id'] = $akpInstrumen->id;
                $akp->generateAkp($this->temp, AkpStatus::ATASAN_REVIEWED);

                return redirect()->to(route('/akp/review/rekan', ['nip' => $this->temp['nip']]));
            }
        } catch (\Throwable $th) {
            return redirect()->to(route('/akp/review/failed', ['message' => 'terjadi kesalahan, mohon menghubungi pihak yang bersangkutan']));
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
