<?php

namespace App\Http\Controllers\Formasi\Service;

use App\Enums\TaskStatus;
use App\Http\Controllers\SearchService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use App\Models\Formasi\Formasi;
use Illuminate\Support\Facades\DB;

class FormasiService extends Formasi
{
    use SearchService;

    public function generateFormasi($jabatan_code): ?FormasiService
    {
        $userContext = auth()->user();
        $formasi = $this->findActiveRequest($userContext->unit_kerja_id, $jabatan_code);
        $formasiDocument = $userContext->unitKerja->formasiDokumen;

        if ($formasi)
            return $formasi;

        $this->jabatan_code = $jabatan_code;
        $this->unit_kerja_id = $userContext->unit_kerja_id;
        $this->formasi_dokumen_id = $userContext->unitKerja->formasiDokumen->id;
        $this->customSave();
        return $this;
    }

    public function findAll()
    {
        return $this
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('task_status', TaskStatus::APPROVE)
            ->get();
    }

    public function findAllByUnitKerjaId($unit_kerja_id)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('task_status', TaskStatus::APPROVE)
            ->get();
    }

    public function findAllByUnitKerjaIdAndRekomendasiFlag($unit_kerja_id, $rekomendasi_flag = false)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('rekomendasi_flag', $rekomendasi_flag)
            ->where('task_status', TaskStatus::APPROVE)
            ->get();
    }

    public function findAllPending()
    {
        return $this
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('task_status', TaskStatus::PENDING)
            ->get();
    }

    public function findAllPendingByUnitKerjaId($unit_kerja_id)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('task_status', TaskStatus::PENDING)
            ->get();
    }

    public function findById($id): ?FormasiService
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByFormasiDokumenId($formasi_dokumen_id): ?FormasiService
    {
        return $this->where('id', $formasi_dokumen_id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByUnitKerjaId($unit_kerja_id)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('task_status', TaskStatus::APPROVE)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findByUnitKerjaIdAll($unit_kerja_id)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('delete_flag', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findRiwayatByUnitKerjaId($unit_kerja_id)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('delete_flag', false)
            ->where('task_status', TaskStatus::APPROVE)
            ->orderBy('inactive_flag', 'asc')
            ->orderByDesc('created_at')
            ->get();
    }

    public function findActiveRequest($unit_kerja_id, $jabatan_code): ?FormasiService
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('jabatan_code', $jabatan_code)
            ->where('inactive_flag', false)
            ->where(function ($query) {
                $query->whereNotIn('task_status', [TaskStatus::APPROVE, TaskStatus::REJECT]);
                $query->orWhere('task_status', null);
            })->orderBy('created_at', 'desc')
            ->first();
    }

    public function findByUnitKerjaIdAndJabatanCode($unit_kerja_id, $jabatan_code)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('jabatan_code', $jabatan_code)
            ->first();
    }

    public function findPendingByUnitKerjaId($unit_kerja_id)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('inactive_flag', false)
            ->where('delete_flag', false)
            ->orWhere('task_status', TaskStatus::PENDING)
            ->get();
    }

    public function findByUnitKerjaIdAndTaskStatus($unit_kerja_id, $task_status = TaskStatus::APPROVE)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('inactive_flag', false)
            ->where('delete_flag', false)
            ->Where('task_status', $task_status)
            ->get();
    }

    public function findByJabatanCodeAndUnitKerjaIdAndTaskStatus($jabatan_code, $unit_kerja_id, $task_status = TaskStatus::APPROVE)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('inactive_flag', false)
            ->where('delete_flag', false)
            ->Where('task_status', $task_status)
            ->Where('jabatan_code', $jabatan_code)
            ->first();
    }

    public function findByUnitKerjaIdAndTaskStatusAndInactiveFlag($unit_kerja_id, $task_status = TaskStatus::APPROVE, $inactive_flag = false)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('inactive_flag', $inactive_flag)
            ->where('delete_flag', false)
            ->Where('task_status', $task_status)
            ->get();
    }

    public function findBetweenConfirmedAndNotConfirmed()
    {
        return $this
            ->where(function ($query) {
                $query->where('task_status', TaskStatus::PENDING)
                    ->where('inactive_flag', true)
                    ->where('delete_flag', false);
            })
            ->orWhere(function ($query) {
                $query->where('task_status', TaskStatus::APPROVE)
                    ->where('inactive_flag', false)
                    ->where('delete_flag', false);
            })
            ->get();
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip;
            $this->save();
        });
    }

    public function calculateAndSaveAll(array $formasiVolumes)
    {
        $userContext = auth()->user();
        $unitKerja = $userContext->unitKerja;
        $pengali = $unitKerja->wilayah->pengali ?? 1;

        $formasiUnsur = new FormasiUnsurService();
        $formasiResultNew = [];
        foreach ($formasiVolumes as $key => $value) {
            $formasiUnsur = $formasiUnsur->findById($key);
            $formasiScore = new FormasiScoreService();
            $formasiScore->saveByFormasiUnsur($formasiUnsur, $this->id, $value);
            $formasiScore = $formasiScore->findByFormasiIdAndFormasiUnsurId($this->id, $key);

            $formasiResultNew[$formasiScore->jenjang_code]['total'] = ($formasiResultNew[$formasiScore->jenjang_code]['total'] ?? 0) + $formasiScore->score;
            $formasiResultNew[$formasiScore->jenjang_code]['sdm'] = ($formasiResultNew[$formasiScore->jenjang_code]['total'] ?? 0) * $pengali;
            $formasiResultNew[$formasiScore->jenjang_code]['pembulatan'] = round(($formasiResultNew[$formasiScore->jenjang_code]['sdm'] ?? 0));
            $formasiResultNew[$formasiScore->jenjang_code]['jenjang_code'] = $formasiScore->jenjang_code;
            $formasiResultNew[$formasiScore->jenjang_code]['formasi_id'] = $this->id;
        }

        $total = 0;
        foreach ($formasiResultNew as $key => $value) {
            $total = $total + $value['pembulatan'];
        }

        DB::transaction(function () use ($formasiResultNew, $total) {
            $formasiResult = new FormasiResultService();
            $formasiResult->customSaveAll($formasiResultNew);
            $this->total = $total;
            $this->task_status = TaskStatus::PENDING;
            $this->customUpdate();
        });
    }

    public function calculateAndUpdateAll(array $formasiVolumes, $unit_kerja_id)
    {
        $unitKerja = new UnitKerjaService();
        $unitKerja = $unitKerja->findById($unit_kerja_id);
        $pengali = $unitKerja->wilayah->pengali ?? 1;

        $formasiUnsur = new FormasiUnsurService();
        $formasiResultNew = [];
        foreach ($formasiVolumes as $key => $value) {
            $formasiUnsur = $formasiUnsur->findById($key);
            $formasiScore = new FormasiScoreService();
            $formasiScore->saveByFormasiUnsur($formasiUnsur, $this->id, $value);
            $formasiScore = $formasiScore->findByFormasiIdAndFormasiUnsurId($this->id, $key);

            $formasiResultNew[$formasiScore->jenjang_code]['total'] = ($formasiResultNew[$formasiScore->jenjang_code]['total'] ?? 0) + $formasiScore->score;
            $formasiResultNew[$formasiScore->jenjang_code]['sdm'] = ($formasiResultNew[$formasiScore->jenjang_code]['total'] ?? 0) * $pengali;
            $formasiResultNew[$formasiScore->jenjang_code]['pembulatan'] = round(($formasiResultNew[$formasiScore->jenjang_code]['sdm'] ?? 0));
            $formasiResultNew[$formasiScore->jenjang_code]['jenjang_code'] = $formasiScore->jenjang_code;
            $formasiResultNew[$formasiScore->jenjang_code]['formasi_id'] = $this->id;
        }

        $total = 0;
        foreach ($formasiResultNew as $key => $value) {
            $total = $total + $value['pembulatan'];
        }

        DB::transaction(function () use ($formasiResultNew, $total) {
            $formasiResult = new FormasiResultService();
            $formasiResult->customSaveAll($formasiResultNew);
            $this->total = $total;
            $this->task_status = TaskStatus::PENDING;
            $this->customUpdate();
        });
    }

    public function updateAllInactive($unit_kerja_id, $jabatan_code)
    {
        $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('jabatan_code', $jabatan_code)
            ->update(['inactive_flag' => true]);
    }

    public function updateAllInactiveExceptId($unit_kerja_id, $jabatan_code, $id)
    {
        $this
            ->where('id', '!=', $id)
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('jabatan_code', $jabatan_code)
            ->update(['inactive_flag' => true]);
    }

    public function customUpdate()
    {
        $userContext = auth()->user();

        $this->updated_by = $userContext->nip;
        $this->save();
    }

    public function customDelete()
    {
        $userContext = auth()->user();

        $this->updated_by = $userContext->nip;
        $this->delete_flag = true;
        $this->save();
    }
}
