<?php

namespace App\Http\Controllers\Maintenance\Service;

use App\Http\Controllers\SearchService;
use App\Models\Maintenance\KabKota;

class KabKotaService extends KabKota
{
    use SearchService;

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findByType($type)
    {
        return $this->where('type', strtoupper($type))
            ->where('delete_flag', false)->get();
    }

    public function findById($id)
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByProvinsiId($provinsi_id)
    {
        return $this->where('provinsi_id', $provinsi_id)
            ->where('delete_flag', false)
            ->get();
    }

    public function findKabupatenByProvinsiId($provinsi_id)
    {
        return $this->where('provinsi_id', $provinsi_id)
            ->where('type', "KABUPATEN")
            ->where('delete_flag', false)
            ->get();
    }

    public function findKotaByProvinsiId($provinsi_id)
    {
        return $this->where('provinsi_id', $provinsi_id)
            ->where('type', "KOTA")
            ->where('delete_flag', false)
            ->get();
    }

    public function customSave()
    {
        $userContext = auth()->user();

        $this->created_by = $userContext->nip;
        $this->save();
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
