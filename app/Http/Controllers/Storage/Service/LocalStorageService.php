<?php

namespace App\Http\Controllers\Storage\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalStorageService
{

    protected $disk;

    public function __construct($disk = 'public')
    {
        $this->disk = $disk;
    }

    public function generateFormat($object_name, UploadedFile $file)
    {
        return $object_name . '.' . $file->getClientOriginalExtension();
    }

    public function putObject($bucket_name, $object_name, UploadedFile $file)
    {
        Storage::disk($this->disk)->putFileAs($bucket_name, $file, $object_name);
    }

    public function putObjectWithFileName(UploadedFile $file, $file_name)
    {
        Storage::disk($this->disk)->putFileAs('', $file, $file_name);
    }

    public function putObjectWithGeneratedFileName(UploadedFile $file)
    {
        Storage::disk($this->disk)->putFileAs('', $file, $this->file_name);
    }

    public function deleteObject($object_name)
    {
        Storage::disk($this->disk)->delete($object_name);
    }

    public function getObject($object_name)
    {
        return Storage::disk($this->disk)->get($object_name);
    }

    public function generateUrl($object_name)
    {
        return asset('/storage/' . $object_name);
    }
}
