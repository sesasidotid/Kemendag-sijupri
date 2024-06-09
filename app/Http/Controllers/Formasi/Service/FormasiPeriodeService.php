<?php

namespace App\Http\Controllers\Formasi\Service;

use App\Http\Controllers\SearchService;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use App\Models\Formasi\FormasiPeriode;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class FormasiPeriodeService extends FormasiPeriode
{
    use SearchService;
    
    private const bucket_name = "formasi";

    public function findAll()
    {
        return $this
            ->where('delete_flag', false)
            ->get();
    }

    public function findById($id): ?FormasiPeriodeService
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function customSaveWithUpload(array $data)
    {
        DB::transaction(function () use ($data) {
            $userContext = auth()->user();
            $suratUndangan = $this->generateFileName([$userContext->nip, 'surat_undangan', now()], $data['file_surat_undangan']);

            $this->file_surat_undangan = $suratUndangan['bucket_file_name'];
            $this->customSave();

            $storage = new LocalStorageService();
            $storage->putObject($this::bucket_name, $suratUndangan['file_name'], $data['file_surat_undangan']);
        });
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
