<?php
namespace Src\Upload\Service;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Src\Upload\Model\UploadedFile;
use Exception;

class UploadService
{
    public function handle(string $base64): array
    {
        $decoded = $this->decodeBase64($base64);
        $this->validatePdf($decoded);

        $fileName = $this->generateFileName();
        $filePath = $this->storeFile($decoded, $fileName);

        // Simpan metadata ke DB
        $uploadedFile = UploadedFile::create([
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);

        return [
            'file_name' => $uploadedFile->file_name,
            'file_url' => Storage::url($uploadedFile->file_path),
        ];
    }

    private function decodeBase64(string $base64): string
    {
        if (str_starts_with($base64, 'data:application/pdf;base64,')) {
            $base64 = substr($base64, strpos($base64, ',') + 1);
        }

        $decoded = base64_decode($base64, true);

        if ($decoded === false) {
            throw new Exception('Base64 decoding failed.');
        }

        return $decoded;
    }

    private function validatePdf(string $data): void
    {
        if (substr($data, 0, 4) !== '%PDF') {
            throw new Exception('The uploaded file is not a valid PDF.');
        }
    }

    private function generateFileName(): string
    {
        return Str::uuid()->toString() . '.pdf';
    }

    private function storeFile(string $data, string $fileName): string
    {
        $filePath = 'uploads/' . $fileName;

        Storage::disk('public')->put($filePath, $data);

        return $filePath;
    }
}
