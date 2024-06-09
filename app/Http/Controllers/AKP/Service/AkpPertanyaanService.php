<?php

namespace App\Http\Controllers\AKP\Service;

use App\Http\Controllers\SearchService;
use App\Models\AKP\AkpPertanyaan;
use Illuminate\Support\Facades\DB;

class AkpPertanyaanService extends AkpPertanyaan
{
    use SearchService;

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($id): ?AkpPertanyaanService
    {
        return $this
            ->where('id', $id)
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
