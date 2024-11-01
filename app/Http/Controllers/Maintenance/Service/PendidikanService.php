<?php

namespace App\Http\Controllers\Maintenance\Service;

use App\Http\Controllers\SearchService;
use App\Models\Maintenance\Pendidikan;

class PendidikanService extends Pendidikan
{
    use SearchService;

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($code)
    {
        $this->where('code', $code)
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
