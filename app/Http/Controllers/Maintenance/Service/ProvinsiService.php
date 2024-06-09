<?php

namespace App\Http\Controllers\Maintenance\Service;

use App\Http\Controllers\SearchService;
use App\Models\Maintenance\Provinsi;

class ProvinsiService extends Provinsi
{
    use SearchService;
    
    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($id): ?ProvinsiService
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function customSave()
    {
        $userContext = auth()->user();

        $this->created_by = $userContext->nip ?? null;
        $this->save();
    }

    public function customUpdate()
    {
        $userContext = auth()->user();

        $this->updated_by = $userContext->nip ?? null;
        $this->save();
    }

    public function customDelete()
    {
        $userContext = auth()->user();

        $this->updated_by = $userContext->nip ?? null;
        $this->delete_flag = true;
        $this->save();
    }
}
