<?php

namespace App\Http\Controllers\Maintenance\Service;

use App\Http\Controllers\SearchService;
use App\Models\Maintenance\Jenjang;

class JenjangService extends Jenjang
{
    use SearchService;

    public function findAll()
    {
        return $this
            ->where('delete_flag', false)
            ->orderBy('urutan', 'desc')
            ->get();
    }

    public function findNextJenjang($urutan)
        {
        return $this
            ->where('urutan', ($urutan + 1))
            ->where('delete_flag', false)
            ->first();
    }
    public function findById($code)
    {
        return $this->where('code', $code)
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
