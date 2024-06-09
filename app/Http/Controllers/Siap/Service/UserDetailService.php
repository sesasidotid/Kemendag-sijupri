<?php

namespace App\Http\Controllers\Siap\Service;

use App\Enums\TaskStatus;
use App\Http\Controllers\SearchService;
use App\Models\Siap\UserDetail;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UserDetailService extends UserDetail
{
    use SearchService;

    private const bucket_name = "user_detail";

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($id): ?UserDetailService
    {
        return $this
            ->where('id', $id)
            ->first();
    }

    public function findByNip($nip): ?UserDetailService
    {
        return $this
            ->where('nip', $nip)
            ->first();
    }

    public function customSaveWithUpload(array $data)
    {
        DB::transaction(function () use ($data) {
            $userContext = auth()->user();
            $userDetail = $this->findByNip($userContext->nip);
            $fileNames = null;


            if ($userDetail) {
                if (isset($data['file_ktp'])) {
                    $fileNames = $this->generateFileName([$userContext->nip, 'ktp'], $data['file_ktp']);
                    $userDetail->file_ktp = $fileNames['bucket_file_name'];
                }
                $userDetail->fill($data);
                $userDetail->task_status = TaskStatus::PENDING;
                $userDetail->comment = null;
                $userDetail->customUpdate();
            } else {
                $fileNames = $this->generateFileName([$userContext->nip, 'ktp'], $data['file_ktp']);
                $this->file_ktp = $fileNames['bucket_file_name'];
                $this->customSave();
            }

            if (isset($data['file_ktp'])) {
                $storage = new LocalStorageService();
                $storage->putObject($this::bucket_name, $fileNames['file_name'], $data['file_ktp']);
            }
        });
    }

    public function customSaveWithoutUpload()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $userDetail = $this->findByNip($userContext->nip);
            if ($userDetail) {
                $userDetail->customUpdate();
            } else {
                $this->customSave();
            }
        });
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

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
