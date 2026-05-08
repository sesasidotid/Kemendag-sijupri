<?php

namespace Eyegil\SijupriSiap\Converters;

use Eyegil\SijupriSiap\Dtos\RiwayatKinerjaDto;
use Eyegil\SijupriSiap\Models\RiwayatKinerja;


class RiwayatKinerjaConverter
{
    public static function toDto(RiwayatKinerja $riwayatKinerja): RiwayatKinerjaDto
    {
        $riwayatKinerjaDto = new RiwayatKinerjaDto();
        $riwayatKinerjaDto->fromModel($riwayatKinerja);

        if($riwayatKinerja->ratingHasil) {
            $riwayatKinerjaDto->rating_hasil_name = $riwayatKinerja->ratingHasil->name;
            $riwayatKinerjaDto->rating_hasil_value = $riwayatKinerja->ratingHasil->value;
        }
        if($riwayatKinerja->ratingKinerja) {
            $riwayatKinerjaDto->rating_kinerja_name = $riwayatKinerja->ratingKinerja->name;
            $riwayatKinerjaDto->rating_kinerja_value = $riwayatKinerja->ratingKinerja->value;
        }
        if($riwayatKinerja->predikatKinerja) {
            $riwayatKinerjaDto->predikat_kinerja_name = $riwayatKinerja->predikatKinerja->name;
            $riwayatKinerjaDto->predikat_kinerja_value = $riwayatKinerja->predikatKinerja->value;
        }

        return $riwayatKinerjaDto;
    }
}
