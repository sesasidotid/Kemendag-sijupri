<?php

namespace App\Http\Controllers\Siap\Service;

use App\Http\Controllers\SearchService;
use App\Models\Maintenance\Instansi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class InstansiService extends Instansi
{
    use SearchService;

    private const bucket_name = "ukom";

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($id): ?InstansiService
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByName($name): ?InstansiService
    {
        return $this->where('name', $name)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByNip($nip)
    {
        return $this
            ->where('nip', $nip)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByTipeInstansi($tipe_instansi_code)
    {
        return $this
            ->where('tipe_instansi_code', $tipe_instansi_code)
            ->where('delete_flag', false)
            ->get();
    }

    public function findLatestByNip($nip): ?InstansiService
    {
        return $this
            ->where('nip', $nip)
            ->where('delete_flag', false)
            ->orderBy('tgl_selesai', 'desc')
            ->first();
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip ?? null;
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
        $file_name = str_replace('-', '', str_replace(':', '', str_replace(' ', '', $file_name)));
        return [
            'file_name' => $file_name,
            'bucket_file_name' => $this::bucket_name . '/' . $file_name,
        ];
    }
}
