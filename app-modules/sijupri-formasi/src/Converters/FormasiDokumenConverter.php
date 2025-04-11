<?php

namespace Eyegil\SijupriFormasi\Converters;

use Eyegil\SijupriFormasi\Dtos\FormasiDokumenDto;
use Eyegil\SijupriFormasi\Models\FormasiDokumen;
use Eyegil\SijupriMaintenance\Models\DokumenPersyaratan;

class FormasiDokumenConverter
{
    public static function toDto(FormasiDokumen $formasiDokumen): FormasiDokumenDto
    {
        $formasiDokumenDto = new FormasiDokumenDto();
        $formasiDokumenDto->dokumen_persyaratan_id = $formasiDokumen->dokumenPersyaratan->id;
        $formasiDokumenDto->dokumen_persyaratan_name = $formasiDokumen->dokumenPersyaratan->name;
        $formasiDokumenDto->dokumen = $formasiDokumen->dokumen;

        return $formasiDokumenDto;
    }
    public static function dokumenPersyaratanToDto(DokumenPersyaratan $dokumenPersyaratan): FormasiDokumenDto
    {
        $formasiDokumenDto = new FormasiDokumenDto();
        $formasiDokumenDto->dokumen_persyaratan_id = $dokumenPersyaratan->id;
        $formasiDokumenDto->dokumen_persyaratan_name = $dokumenPersyaratan->name;

        return $formasiDokumenDto;
    }
}
