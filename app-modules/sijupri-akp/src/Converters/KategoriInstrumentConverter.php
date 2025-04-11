<?php

namespace Eyegil\SijupriAkp\Converters;

use Eyegil\SijupriAkp\Dtos\AkpDto;
use Eyegil\SijupriAkp\Dtos\KategoriInstrumentDto;
use Eyegil\SijupriAkp\Models\Akp;
use Eyegil\SijupriAkp\Models\KategoriInstrument;
use Eyegil\SijupriSiap\Converters\JFConverter;

class KategoriInstrumentConverter
{
    public static function toDto(KategoriInstrument $kategoriInstrument): KategoriInstrumentDto
    {
        $kategoriInstrumentDto = new KategoriInstrumentDto();
        $kategoriInstrumentDto->fromArray($kategoriInstrument->toArray());
        $kategoriInstrumentDto->instrument_name = optional($kategoriInstrument->instrument)->name;
        $kategoriInstrumentDto->pelatihan_teknis_name = optional($kategoriInstrument->pelatihanTeknis)->name;

        return $kategoriInstrumentDto;
    }
}
