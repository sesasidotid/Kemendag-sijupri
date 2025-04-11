<?php

namespace Eyegil\SijupriMaintenance\Converters;

use Eyegil\SijupriMaintenance\Dtos\PelatihanTeknisDto;
use Eyegil\SijupriMaintenance\Models\PelatihanTeknis;

class PelatihanTeknisConverter
{
    public static function toDto(PelatihanTeknis $pelatihanTeknis): PelatihanTeknisDto
    {
        $pelatihanTeknisDto = (new PelatihanTeknisDto)->fromModel($pelatihanTeknis);
        $pelatihanTeknisDto->jabatan_name = $pelatihanTeknis->jabatan->name;

        return $pelatihanTeknisDto;
    }
}
