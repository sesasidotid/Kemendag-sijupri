<?php

namespace App\Http\Controllers\Ukom\Service;

use App\Enums\TaskStatus;
use App\Http\Controllers\SearchService;
use App\Models\Ukom\UkomJadwal;
use Illuminate\Support\Facades\DB;

class UkomJadwalService extends UkomJadwal
{
    use SearchService;

    public function findAll()
    {
        return $this
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
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

    public function findById($id)
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip;
            $this->save();
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
