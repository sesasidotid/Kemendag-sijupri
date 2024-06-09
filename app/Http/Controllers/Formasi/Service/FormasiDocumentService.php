<?php

namespace App\Http\Controllers\Formasi\Service;

use App\Http\Controllers\SearchService;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use App\Models\Formasi\FormasiDokumen;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class FormasiDocumentService extends FormasiDokumen
{
    use SearchService;

    private const bucket_name = "formasi";

    public function getDokumenFormasi($unit_kerja_id = null): ?FormasiDocumentService
    {
        if ($unit_kerja_id == null) {
            $userContext = auth()->user();
            $unit_kerja_id = $userContext->unit_kerja_id;
        }
        $formasiDocument = $this->findByUnitKerjaId($unit_kerja_id);
        if ($formasiDocument)
            return $formasiDocument;
        else {
            $this->fill(['unit_kerja_id' => $unit_kerja_id]);
            $this->customSave();
            return $this;
        }
    }

    public function findAll()
    {
        return $this->all();
    }

    public function findById($id): ?FormasiDocumentService
    {
        return $this
            ->where('id', $id)
            ->first();
    }

    public function findByUnitKerjaId($unit_kerja_id)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->orderBy('waktu_pelaksanaan', "DESC")
            ->get();
    }

    public function findByUnitKerjaIdAndInactiveFlag($unit_kerja_id, $inactive_flag = false)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('inactive_flag', $inactive_flag)
            ->first();
    }

    public function saveAndUpload($file, $file_param)
    {
        DB::transaction(function () use ($file, $file_param) {
            $userContext = auth()->user();
            $fileNames = $this->generateFileName([$userContext->nip, $file_param], $file);
            $this->$file_param = $fileNames['bucket_file_name'];
            $this->customUpdate();

            $storageService = new LocalStorageService();
            $storageService->putObject($this::bucket_name, $fileNames['file_name'], $file);
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
        $file_name = str_replace('-', '', str_replace(':', '', str_replace(' ', '', $file_name)));
        return [
            'file_name' => $file_name,
            'bucket_file_name' => $this::bucket_name . '/' . $file_name,
        ];
    }
}
