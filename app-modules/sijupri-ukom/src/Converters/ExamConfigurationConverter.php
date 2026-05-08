<?php

namespace Eyegil\SijupriUkom\Converters;

use Eyegil\SijupriUkom\Dtos\ExamConfigurationDto;
use Eyegil\SijupriUkom\Dtos\ExamSuffleConfigurationDto;
use Eyegil\SijupriUkom\Models\ExamConfiguration;

class ExamConfigurationConverter
{

    public static function toDto(ExamConfiguration $examConfiguration)
    {
        $examConfigurationDto = new ExamConfigurationDto();
        $examConfigurationDto->fromArray($examConfiguration->toArray());
        $examConfigurationDto->exam_shuffle_configuration_dto_list = [];
        foreach ($examConfiguration->examSuffleConfigurationList as $key => $examSuffleConfiguration) {
            $examShuffelConfigurationDto = new ExamSuffleConfigurationDto();
            $examShuffelConfigurationDto->fromArray($examSuffleConfiguration->toArray());
            $examShuffelConfigurationDto->kompetensi_indikator_name = $examSuffleConfiguration->kompetensiIndikator->name;

            $examConfigurationDto->exam_shuffle_configuration_dto_list[] = $examShuffelConfigurationDto;
        }

        return $examConfigurationDto;
    }
}
