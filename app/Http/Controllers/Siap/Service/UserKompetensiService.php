<?php

namespace App\Http\Controllers\Siap\Service;

use App\Enums\TaskStatus;
use App\Http\Controllers\SearchService;
use App\Models\Siap\UserKompetensi;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UserKompetensiService extends UserKompetensi
{
    use SearchService;
    
    private const bucket_name = "kompetensi";

    public function findAll()
    {
        return $this
            ->where('delete_flag', false)
            ->get();
    }

    public function findAllByTaskStatus($task_status)
    {
        return $this
            ->where('task_status', $task_status)
            ->where('delete_flag', false)
            ->get();
    }

    public function findById($id): ?UserKompetensiService
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByNipAndNotReject($nip)
    {
        return $this
            ->where('nip', $nip)
            ->where('task_status', '!=', TaskStatus::REJECT)
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

    public function findLatestByNip($nip): ?UserKompetensiService
    {
        return $this
            ->where('nip', $nip)
            ->where('delete_flag', false)
            ->orderBy('tgl_selesai', 'desc')
            ->first();
    }

    public function customSaveWithUpload(array $data)
    {
        DB::transaction(function () use ($data) {
            $userContext = auth()->user();

            $storage = new LocalStorageService();

            $fileNames = [];
            foreach ($data as $key => $value) {
                if (str_starts_with($key, "file_")) {
                    $fileNames[$key] = $this->generateFileName([$userContext->nip, $key, now()], $value);
                    $this->$key = $fileNames[$key]['bucket_file_name'];
                }
            }
            if (isset($data['id'])) $this->customUpdate();
            else $this->customSave();

            foreach ($fileNames as $key => $value) {
                $storage->putObject($this::bucket_name, $value['file_name'], $data[$key]);
            }
        });
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
