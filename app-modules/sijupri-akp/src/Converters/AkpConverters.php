<?php

namespace Eyegil\SijupriAkp\Converters;

use Eyegil\SijupriAkp\Dtos\AkpDto;
use Eyegil\SijupriAkp\Dtos\AkpRekapDto;
use Eyegil\SijupriAkp\Dtos\Matrix1Dto;
use Eyegil\SijupriAkp\Dtos\Matrix2Dto;
use Eyegil\SijupriAkp\Dtos\Matrix3Dto;
use Eyegil\SijupriAkp\Models\Akp;
use Eyegil\SijupriSiap\Converters\JFConverter;
use Eyegil\StorageBase\Services\StorageService;

class AkpConverters
{
    public static function toDto(Akp $akp, StorageService $storageService = null): AkpDto
    {
        $akpDto = new AkpDto();
        $akpDto->fromArray(JFConverter::toDto($akp->jf)->toArray());

        $akpDto->fromModel($akp);
        $akpDto->matrix1_dto_list = [];
        $akpDto->matrix2_dto_list = [];
        $akpDto->matrix3_dto_list = [];
        $akpDto->akp_rekap_dto_list = [];

        foreach ($akp->matrixList as $key => $matrix) {
            $pertanyaan = $matrix->pertanyaan;

            $matrix1 = $matrix->matrix1;
            if ($matrix1) {
                $matrix1Dto = new Matrix1Dto();
                $matrix1Dto->fromModel($matrix1);
                $matrix1Dto->pertanyaan_id = $pertanyaan->id;
                $matrix1Dto->pertanyaan_name = $pertanyaan->name;
                $akpDto->matrix1_dto_list[] = $matrix1Dto;
            }

            $matrix2 = $matrix->matrix2;
            if ($matrix2) {
                $matrix2Dto = new Matrix2Dto();
                $matrix2Dto->fromModel($matrix2);
                $matrix2Dto->pertanyaan_id = $pertanyaan->id;
                $matrix2Dto->pertanyaan_name = $pertanyaan->name;
                $akpDto->matrix2_dto_list[] = $matrix2Dto;
            }

            $matrix3 = $matrix->matrix3;
            if ($matrix3) {
                $matrix3Dto = new Matrix3Dto();
                $matrix3Dto->fromModel($matrix3);
                $matrix3Dto->pertanyaan_id = $pertanyaan->id;
                $matrix3Dto->pertanyaan_name = $pertanyaan->name;
                $akpDto->matrix3_dto_list[] = $matrix3Dto;
            }

            $akpRekap = $matrix->akpRekap;
            if ($akpRekap) {
                $akpRekapDto = new AkpRekapDto();
                $akpRekapDto->fromModel($akpRekap);
                $akpRekapDto->pertanyaan_id = $pertanyaan->id;
                $akpRekapDto->pertanyaan_name = $pertanyaan->name;
                $akpRekapDto->pelatihan_teknis_name = optional($akpRekap->pelatihanTeknis)->name ?? null;
                if($storageService && $akpRekapDto->dokumen_verifikasi) {
                    $akpRekapDto->dokumen_verifikasi_url = $storageService->getUrl("system", "akp", $akpRekapDto->dokumen_verifikasi);
                }

                $akpDto->akp_rekap_dto_list[] = $akpRekapDto;
            }
        }

        return $akpDto;
    }
}
