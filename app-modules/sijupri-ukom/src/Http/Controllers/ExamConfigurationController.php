<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\SijupriUkom\Converters\ExamConfigurationConverter;
use Eyegil\SijupriUkom\Dtos\ExamConfigurationDto;
use Eyegil\SijupriUkom\Services\ExamConfigurationService;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Http\Request;

#[Controller("/api/v1/exam_config")]
class ExamConfigurationController
{
    public function __construct(
        private ExamConfigurationService $examConfigurationService
    ) {
    }

    #[Get("/exam_schedule/{exam_schedule_id}")]
    public function findByExamScheduleId($exam_schedule_id)
    {
        $result = $this->examConfigurationService->findByExamScheduleId($exam_schedule_id);
        if (!$result) {
            throw new RecordNotFoundException("exam schedule with id : $exam_schedule_id not found");
        }
        return ExamConfigurationConverter::toDto($result);
    }

    #[Post("/shuffle")]
    public function shuffle(Request $request)
    {
        $examConfigurationDto = ExamConfigurationDto::fromRequest($request)->validateShuffle();
        $this->examConfigurationService->shuffle($examConfigurationDto);
    }
}
