<?php

namespace Eyegil\SijupriUkom\Services;

use DB;
use Eyegil\SijupriUkom\Dtos\ExamConfigurationDto;
use Eyegil\SijupriUkom\Dtos\ExamSuffleConfigurationDto;
use Eyegil\SijupriUkom\Models\ExamConfiguration;
use Eyegil\SijupriUkom\Models\ExamSuffleConfiguration;
use Log;

class ExamConfigurationService
{

    public function __construct(
    ) {
    }

    public function findById($id)
    {
        return ExamConfiguration::findOrThrowNotFound($id);
    }

    public function findByExamScheduleId($exam_schedule_id)
    {
        return ExamConfiguration::with(["examSuffleConfigurationList.kompetensiIndikator"])->where("exam_schedule_id", $exam_schedule_id)->first();
    }

    public function shuffle(ExamConfigurationDto $examConfigurationDto)
    {
        DB::transaction(function () use ($examConfigurationDto) {
            if ($examConfigurationDto->exam_shuffle_configuration_dto_list != null) {
                $examConfiguration = $this->findByExamScheduleId($examConfigurationDto->exam_schedule_id);

                ExamSuffleConfiguration::where("exam_configuration_id", $examConfiguration->id)->delete();
                foreach ($examConfigurationDto->exam_shuffle_configuration_dto_list as $examSuffleConfigurationDtoArr) {
                    $examSuffleConfigurationDto = new ExamSuffleConfigurationDto();
                    $examSuffleConfigurationDto->fromArray((array) $examSuffleConfigurationDtoArr);

                    $examSuffleConfiguration = new ExamSuffleConfiguration();
                    $examSuffleConfiguration->fromArray($examSuffleConfigurationDto->toArray());
                    $examSuffleConfiguration->exam_configuration_id = $examConfiguration->id;
                    $examSuffleConfiguration->saveWithUuid();
                }
            }
        });
    }
}
