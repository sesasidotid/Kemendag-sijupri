<?php

namespace App\Http\Controllers\Siap\Service;

use App\Http\Controllers\SearchService;
use App\Models\Siap\UserAkp;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UserAkpService extends UserAkp
{
    use SearchService;
    
    private const bucket_name = "akp";

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($id)
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByNip($nip)
    {
        return $this
            ->where('nip', $nip)
            ->where('delete_flag', false)
            ->get();
    }
    
    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip;
            $this->nip = $userContext->nip;
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

    private function generateFileName(array $cr, UploadedFile $file)
    {
        $file_name = '';
        foreach ($cr as $key => $value) {
            if ($file_name === '')
                $file_name = $file_name . $value;
            else
                $file_name = $file_name . '_' . $value;
        }
        
        $file_name = $file_name . '.' . $file->getClientOriginalExtension();
        $file_name = str_replace('-', '', str_replace(':', '', str_replace(' ', '', $file_name)));
        return [
            'file_name' => $file_name,
            'bucket_file_name' => $this::bucket_name . '/' . $file_name,
        ];
    }
}
