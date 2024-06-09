<?php

namespace App\Http\Livewire\Formasi;

use App\Exceptions\BusinessException;
use Livewire\Component;
use App\Http\Controllers\Formasi\Service\FormasiDocumentService;
use App\Http\Controllers\Formasi\Service\FormasiScoreService;
use App\Http\Controllers\Formasi\Service\FormasiService;
use App\Http\Controllers\Formasi\Service\FormasiUnsurService;
use App\Models\Audit\AuditTimeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FormasiPerhitungan extends Component
{
    public $jabatan_code;

    public $formasi, $formasiUnsur;

    public $data = [];

    public $request = [];

    public function mount($jabatan_code, FormasiService $formasi, FormasiUnsurService $formasiUnsur)
    {
        $this->jabatan_code = $jabatan_code;
        $this->formasi = $formasi->generateFormasi($jabatan_code);
        $this->formasiUnsur = $formasiUnsur;
    }

    public function render()
    {
        $formasiUnsurList = $this->formasiUnsur->findAllParent($this->jabatan_code);
        $formasiData = $this->formasi;
        $this->setDefaultValue($formasiUnsurList, $formasiData->id);

        return view('livewire.formasi.formasi-perhitungan', compact(
            'formasiUnsurList',
            'formasiData'
        ));
    }

    public function store(FormasiService $formasi)
    {
        foreach ($this->request as $key => $value) {
            $this->validate([
                "request." . $key => 'required',
            ]);
        }

        DB::transaction(function () use ($formasi) {
            $userContext = auth()->user();

            $formasi = $formasi->generateFormasi($this->jabatan_code);
            $formasi->calculateAndSaveAll($this->request);

            AuditTimeline::create([
                'association' => 'tbl_formasi_dokumen',
                'association_key' => $userContext->unitKerja->formasiDokumen->id,
                'description' => 'Pendaftaran Formasi Jabatan ' . $formasi->jabatan->name
            ]);
        });

        session()->flash('response', ['title' => 'Success', 'message' => "Berhasil", 'icon' => 'success']);

        return redirect()->to(route('/formasi/pendaftaran_formasi/detail', ['jabatan_code' => $this->jabatan_code]));
    }

    public function updatedRequest($volume, $formasi_unsur_id)
    {
        $this->validate([
            'request.' . $formasi_unsur_id => 'required',
        ]);

        $formasiUnsur = new FormasiUnsurService();
        $formasiUnsur = $formasiUnsur->findById($formasi_unsur_id);

        $formasiScore = new FormasiScoreService();
        $formasiScore->saveByFormasiUnsur($formasiUnsur, $this->formasi->id, $volume);
    }

    private function setDefaultValue($child, $formasi_id)
    {
        foreach ($child as $key => $value) {
            if (is_object($value)) {
                $ch = $value->childUnsur($formasi_id);
                if ($ch->isNotEmpty()) {
                    $this->setDefaultValue($ch, $formasi_id);
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
