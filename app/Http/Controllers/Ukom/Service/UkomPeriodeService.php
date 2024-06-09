<?php

namespace App\Http\Controllers\Ukom\Service;

use App\Enums\TaskStatus;
use App\Http\Controllers\SearchService;
use App\Models\Ukom\UkomPeriode;
use Illuminate\Support\Facades\DB;

class UkomPeriodeService extends UkomPeriode
{
    use SearchService;
    
    public function findAll()
    {
        $this->setInactive();
        return $this
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->orderBy('periode', 'desc')
            ->get();
    }
    public function findAllExcludeInactiveFlag()
    {
        $this->setInactive();
        return $this
            ->where('delete_flag', false)
            ->orderBy('periode', 'desc')
            ->get();
    }

    public function cekPeriode($task)
    {
        $this->setInactive();
        return $this
            ->where('task_status', $task)
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->first();
    }

    public function findPengunguman()
    {
        $this->setInactive();
        return $this->where('task_status', TaskStatus::APPROVE)
            ->where('delete_flag', false)
            ->first();
    }

    public function findById($id): ?UkomPeriodeService
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByPeriode($periode): ?UkomPeriodeService
    {
        return $this->where('periode', $periode)
            ->where('delete_flag', false)
            ->first();
    }

    public function setInactive()
    {
        $this
            ->where('tgl_tutup_pendaftaran', '<', date('Y-m-d'))
            ->update(['inactive_flag' => true]);
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();
            $this->created_by = $userContext->nip;
            $this->save();
        });
    }
    public function updateStatus($id, $id_pengumuman, $status)
    {
        DB::transaction(function () use ($id, $id_pengumuman, $status) {
            $val = $this->findById($id);
            $userContext = auth()->user();
            $val->pengumuman_id = $id_pengumuman;
            $val->updated_by = $userContext->nip;
            $val->task_status = $status;
            $val->save();
        });
    }

    public function updateAllInactive(array $ids = [])
    {
        DB::transaction(function () use ($ids) {
            $userContext = auth()->user();

            $this->whereNotIn('id', $ids)->update([
                'updated_by' => $userContext->nip,
                'inactive_flag' => true,
            ]);
        });
    }

    public function customUpdate()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->save();
        });
    }

    public function customDelete()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->delete_flag = true;
            $this->save();
        });
    }
}
