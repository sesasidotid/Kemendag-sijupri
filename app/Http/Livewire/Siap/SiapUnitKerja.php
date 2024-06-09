<?php

namespace App\Http\Livewire\Siap;

use App\Enums\RoleCode;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Maintenance\Service\WilayahService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SiapUnitKerja extends Component
{
    public $unitKerja, $wilayah;
    public $request = [];

    public function mount(UnitKerjaService $unitKerja, WilayahService $wilayah)
    {
        $this->unitKerja = $unitKerja;
        $this->wilayah = $wilayah;
    }

    public function render()
    {
        $userContext = auth()->user();
        $role = $userContext->role;

        if ($role->base == RoleCode::ADMIN_SIJUPRI) {
            $unitKerjaList = $this->unitKerja->findAll();
        } else {
            $unitKerjaList = $this->unitKerja->findByTipeInstansiCodeAndInstansiId($userContext->tipe_instansi_code, $userContext->instansi_id);
        }

        $unitKerjaContext = $userContext->unitKerja;
        $wilayahList = $this->wilayah->findAll();
        $provinsi = $unitKerjaContext->provinsi ?? null;
        $kabupaten = $unitKerjaContext->kabupaten ?? null;
        $kota = $unitKerjaContext->kota ?? null;
        $instansi = $userContext->instansi;

        return view('livewire.siap.siap-unit-kerja', compact(
            'unitKerjaList',
            'wilayahList',
            'provinsi',
            'kabupaten',
            'kota',
            'wilayahList',
            'instansi',
        ));
    }

    public function store(UnitKerjaService $unitKerja)
    {
        $userContext = auth()->user();
        $this->validate([
            // "request.wilayah_code" => 'required',
            "request.name" => 'required',
            "request.email" => 'required|email',
            "request.phone" => 'required:min:10|max:15',
            "request.alamat" => 'required',
        ]);
        if ($userContext->role->base == RoleCode::ADMIN_SIJUPRI) {
            $this->validate([
                "request.tipe_instansi_code" => 'required',
                "request.provinsi_id" => 'required',
                "request.kabupaten_id" => 'required',
            ]);
        } else if ($userContext->role->base == RoleCode::ADMIN_INSTANSI) {
            $this->request['tipe_instansi_code'] = $userContext->tipe_instansi_code;
            if ($userContext->tipe_instansi_code === 'provinsi') {
                $this->request['provinsi_id'] = $userContext->instansi->provinsi_id;
            } else if ($userContext->tipe_instansi_code === 'kabupaten') {
                $this->request['provinsi_id'] = $userContext->instansi->provinsi_id;
                $this->request['kabupaten_id'] = $userContext->instansi->kabupaten_id;
            } else if ($userContext->tipe_instansi_code === 'kota') {
                $this->request['provinsi_id'] = $userContext->instansi->provinsi_id;
                $this->request['kota_id'] = $userContext->instansi->kota_id;
            }
        }

        $unitKerja->fill($this->request);
        $unitKerja->customSave();

        $this->request = [];

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);

        Session::flash('status', 1);
        return redirect()->route('/maintenance/unit_kerja_instansi_daerah');
    }

    private function setEmpty()
    {
        foreach ($this->request as $key => $value) {
            $this->request[$key] = null;
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
