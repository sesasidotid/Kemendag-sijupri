<?php

namespace App\Http\Controllers\Maintenance\Service;

use App\Enums\TaskStatus;
use App\Http\Controllers\SearchService;
use App\Http\Controllers\Storage\Service\LocalStorageService;
use App\Models\Maintenance\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StorageService extends Storage
{
    use SearchService;
    
    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($id): ?StorageService
    {
        return $this
            ->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByAssociationAndAssociationKey($association, $association_key)
    {
        return $this
            ->where('association', $association)
            ->where('association_key', $association_key)
            ->where('delete_flag', false)
            ->get();
    }

    public function customSaveWithUpload(array $data, array $file_property, $bucket_name, $association, $association_key)
    {
        DB::transaction(function () use ($data, $file_property, $bucket_name, $association, $association_key) {
            $userContext = auth()->user();

            $files = [];
            foreach ($file_property as $key => $value) {
                $storage = new StorageService();
                $name = str_replace(' ', '_', strtolower($value));
                $variable = $this->generateFileName([$userContext->nip ?? $data['nip'], $name, now()], $data[$name], $bucket_name);
                $storage->file = $variable['bucket_file_name'];
                $storage->association = $association;
                $storage->association_key = $association_key;
                $storage->name = $value;
                $storage->task_status = TaskStatus::APPROVE;

                $storage->customSave();

                $file['file'] = $name;
                $file['file_name'] = $variable['file_name'];
                $files[] = $file;
            }

            foreach ($files as $key => $value) {
                $storage = new LocalStorageService();
                $storage->putObject($bucket_name, $value['file_name'], $data[$value['file']]);
            }
        });
    }

    public function customSave()
    {
        $userContext = auth()->user();

        $this->created_by = $userContext->nip ?? '';
        $this->save();
    }

    public function customUpdateWithUpload(array $data, $bucket_name, $association, $object)
    {
        DB::transaction(function () use ($data, $bucket_name, $association, $object) {
            $userContext = auth()->user();
            $storageList = $object->storage;

            $files = [];
            foreach ($storageList as $idx => $storage) {
                $name = str_replace(' ', '_', strtolower($storage->name));
                if (isset($data['storage'][$storage->id])) {
                    $variable = $this->generateFileName([$userContext->nip ?? $object->nip, $name, now()], $data['storage'][$storage->id], $bucket_name);
                    $storage->file = $variable['bucket_file_name'];
                    $storage->task_status = TaskStatus::APPROVE;

                    $this->updated_by = $userContext->nip ?? '';
                    $storage->save();

                    $file['file'] = $storage->id;
                    $file['file_name'] = $variable['file_name'];
                    $files[] = $file;
                }
            }

            foreach ($files as $key => $value) {
                $storage = new LocalStorageService();
                $storage->putObject($bucket_name, $value['file_name'], $data['storage'][$value['file']]);
            }
        });
    }

    public function customUpdate()
    {
        $userContext = auth()->user();

        $this->updated_by = $userContext->nip ?? '';
        $this->save();
    }

    public function customDelete()
    {
        $userContext = auth()->user();

        $this->updated_by = $userContext->nip;
        $this->delete_flag = true;
        $this->save();
    }

    private function generateFileName(array $cr, UploadedFile $file, $bucket_name)
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
            'bucket_file_name' => $bucket_name . '/' . $file_name,
        ];
    }
}
