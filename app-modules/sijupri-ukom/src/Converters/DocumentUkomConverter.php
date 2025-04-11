<?php

namespace Eyegil\SijupriUkom\Converters;

use Eyegil\SijupriMaintenance\Models\DokumenPersyaratan;
use Eyegil\SijupriUkom\Dtos\DocumentUkomDto;
use Eyegil\SijupriUkom\Models\DocumentUkom;

class DocumentUkomConverter
{
    public static function toDto(DocumentUkom $formasiDokumen): DocumentUkomDto
    {
        $formasiDokumenDto = new DocumentUkomDto();
        $formasiDokumenDto->dokumen_persyaratan_id = $formasiDokumen->dokumenPersyaratan->id;
        $formasiDokumenDto->dokumen_persyaratan_name = $formasiDokumen->dokumenPersyaratan->name;
        $formasiDokumenDto->dokumen = $formasiDokumen->dokumen;

        return $formasiDokumenDto;
    }
    public static function dokumenPersyaratanToDto(DokumenPersyaratan $dokumenPersyaratan): DocumentUkomDto
    {
        $formasiDokumenDto = new DocumentUkomDto();
        $formasiDokumenDto->dokumen_persyaratan_id = $dokumenPersyaratan->id;
        $formasiDokumenDto->dokumen_persyaratan_name = $dokumenPersyaratan->name;

        return $formasiDokumenDto;
    }
}
