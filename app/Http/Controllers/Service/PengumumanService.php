<?php

namespace App\Http\Controllers\Service;

use App\Enums\TaskStatus;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\DB;

class PengumumanService extends Pengumuman
{

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
