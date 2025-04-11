<?php

namespace Eyegil\SijupriFormasi\Converters;

use Eyegil\SijupriFormasi\Dtos\FormasiDto;
use Eyegil\SijupriFormasi\Dtos\FormasiResultDto;
use Eyegil\SijupriFormasi\Models\Formasi;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\Log;

class FormasiConverter
{
    public static function toDto(Formasi $formasi): FormasiDto
    {
        $formasiDto = (new FormasiDto())->fromModel($formasi);

        $formasiDto->formasi_detail_dto_list = [];
        foreach ($formasi->formasiDetailList as $key => $formasiDetail) {
            $formasiDto->formasi_detail_dto_list[] = FormasiDetailConverter::toDtoWithFormasiResult($formasiDetail);
        }
        return $formasiDto;
    }

    public static function toDtoWithStorage(Formasi $formasi, StorageService $storageService): FormasiDto
    {
        $formasiDto = static::toDto($formasi);
        $formasiDto->rekomendasi_url = $storageService->getUrl("system", "formasi", $formasiDto->rekomendasi);
        return $formasiDto;
    }

    public static function toDtoWithDocumentStorage(Formasi $formasi, StorageService $storageService): FormasiDto
    {
        $formasiDto = static::toDto($formasi);

        $formasiDto->formasi_dokumen_list = [];
        foreach ($formasi->formasiDokumenList as $key => $formasiDokumen) {
            $formasiDokumenDto = FormasiDokumenConverter::toDto($formasiDokumen);
            $formasiDokumenDto->dokumen_url = $storageService->getUrl("system", "formasi", $formasiDokumenDto->dokumen);
            $formasiDto->formasi_dokumen_list[] = $formasiDokumenDto;
        }

        $formasiDto->rekomendasi_url = $storageService->getUrl("system", "formasi", $formasiDto->rekomendasi);
        return $formasiDto;
    }
}
