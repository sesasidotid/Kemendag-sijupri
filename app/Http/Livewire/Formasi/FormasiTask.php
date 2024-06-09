<?php

namespace App\Http\Livewire\Formasi;

use App\Enums\TaskStatus;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Formasi\Service\FormasiDocumentService;
use App\Http\Controllers\Formasi\Service\FormasiService;
use App\Http\Controllers\Formasi\Service\FormasiUnsurService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use App\Models\Audit\AuditTimeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class FormasiTask extends Component
{
    public $formasi_id = null, $isUpdateForm = false;

    public $unitKerja, $formasi, $formasiUnsur;
    public $formasiDocument;
    public $request = [];

    public function mount($formasi_id, UnitKerjaService $unitKerja, FormasiService $formasi, FormasiUnsurService $formasiUnsur, FormasiDocumentService $formasiDocument)
    {
        $this->formasi_id = $formasi_id;
        $this->unitKerja = $unitKerja;
        $this->formasi = $formasi;
        $this->formasiUnsur = $formasiUnsur;
        $this->formasiDocument = $formasiDocument;
    }

    public function render()
    {
        $this->formasi = $this->formasi->findById($this->formasi_id);
        $this->unitKerja = $this->unitKerja->findById($this->formasi->unit_kerja_id);
        $isDokumenVerified = $this->checkDokumenValidation($this->formasi->unit_kerja_id);

        if (!$isDokumenVerified)
            return $this->taskDokumen();
        else {
            if ($this->isUpdateForm)
                return $this->taskUpdate();
            else
                return $this->taskFormasi();
        }
    }

    private function taskDokumen()
    {
        $isDokumenVerified = false;
        return view('livewire.formasi.formasi-task', compact(
            'isDokumenVerified'
        ));
    }

    private function taskUpdate()
    {
        $isDokumenVerified = true;
        $formasiUnsurList = $this->formasiUnsur->findAllParent($this->formasi->jabatan_code);

        if (empty($this->request))
            $this->setDefaultValue($formasiUnsurList);
        return view('livewire.formasi.formasi-task', compact(
            'isDokumenVerified',
            'formasiUnsurList'
        ));
    }

    public function store(FormasiService $formasi)
    {
        foreach ($this->request as $key => $value) {
            $this->validate([
                "request." . $key => 'required',
            ]);
        }

        $formasi = DB::transaction(function () use ($formasi) {
            $formasi = $formasi->findActiveRequest($this->formasi->unit_kerja_id, $this->formasi->jabatan_code);
            $formasi->calculateAndUpdateAll($this->request, $this->formasi->unit_kerja_id);

            return $formasi;
        });

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);

        return redirect()->route('/formasi/request_formasi/detail_formasi', ['id' => $formasi->id]);
    }

    private function taskFormasi()
    {
        $isDokumenVerified = true;
        return view('livewire.formasi.formasi-task', compact(
            'isDokumenVerified'
        ));
    }

    public function verifikasiFormasi()
    {
        DB::transaction(function () {
            $formasi = $this->formasi->findById($this->formasi_id);
            $this->formasi->updateAllInactiveExceptId($formasi->unit_kerja_id, $formasi->jabatan_code, $formasi->id);

            $formasi->task_status = TaskStatus::APPROVE;
            $formasi->inactive_flag = false;
            $formasi->customUpdate();

            AuditTimeline::create([
                'association' => 'tbl_formasi',
                'association_key' => $formasi->id,
                'description' => 'usulan diterima'
            ]);
        });
        return redirect()->to(route('/formasi/request_formasi'));
    }

    public function verifikasiDokumen($property)
    {
        $this->formasiDocument->$property = true;
        $this->formasiDocument->customUpdate();
    }

    public function batalVerifikasiDokumen($property)
    {
        $this->formasiDocument->$property = false;
        $this->formasiDocument->customUpdate();
    }

    private function checkDokumenValidation($unit_kerja_id)
    {
        $this->formasiDocument = $this->formasiDocument->getDokumenFormasi($unit_kerja_id);
        foreach ($this->formasiDocument->toArray() as $key => $value) {
            if (Str::contains($key, 'status')) {
                if (!$value) {
                    return false;
                }
            }
        }

        return true;
    }

    private function setDefaultValue($child)
    {
        foreach ($child as $key => $value) {
            if (is_object($value)) {
                $ch = $value->childUnsur($this->formasi_id);
                if ($ch->isNotEmpty()) {
                    $this->setDefaultValue($ch);
                } else {
                    $this->request[$value->id] = $value->volume ?? 0;
                }
            }
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
