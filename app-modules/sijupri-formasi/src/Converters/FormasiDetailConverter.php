<?php

namespace Eyegil\SijupriFormasi\Converters;

use Eyegil\SijupriFormasi\Dtos\FormasiDetailDto;
use Eyegil\SijupriFormasi\Dtos\FormasiResultDto;
use Eyegil\SijupriFormasi\Models\FormasiDetail;

class FormasiDetailConverter
{
    public static function toDto(FormasiDetail $formasiDokumen): FormasiDetailDto
    {
        $formasiDetailDto = (new FormasiDetailDto())->fromModel($formasiDokumen);
        $formasiDetailDto->jabatan_name = $formasiDokumen->jabatan->name;
        return $formasiDetailDto;
    }

    public static function toDtoWithFormasiResult(FormasiDetail $formasiDokumen)
    {
        $formasiDetailDto = static::toDto($formasiDokumen);

        $formasiDetailDto->formasi_result_dto_list = [];
        foreach ($formasiDokumen->formasiResultList as $key => $formasiResult) {
            $formasiResultDto = (new FormasiResultDto())->fromModel($formasiResult);
            $formasiResultDto->jenjang_name = $formasiResult->jenjang->name;

            $formasiDetailDto->formasi_result_dto_list[] = $formasiResultDto;
        }

        return $formasiDetailDto;
    }
}
