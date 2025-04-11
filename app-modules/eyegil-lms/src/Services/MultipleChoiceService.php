<?php

namespace Eyegil\EyegilLms\Services;

use Eyegil\EyegilLms\Dtos\MultipleChoiceDto;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Models\MultipleChoice;
use Illuminate\Support\Facades\DB;

class MultipleChoiceService
{
    public function save(QuestionDto $questionDto)
    {
        return DB::transaction(function () use ($questionDto) {
            $userContext = user_context();

            foreach ($questionDto->multiple_choice_dto_list as $key => $multiple_choice_dto) {
                $multipleChoiceDto = (new MultipleChoiceDto())->fromArray((array) $multiple_choice_dto);

                $multipleChoice = new MultipleChoice();
                $multipleChoice->fromArray($multipleChoiceDto->toArray());
                $multipleChoice->created_by = $userContext->id;
                $multipleChoice->question_id = $questionDto->id;
                $multipleChoice->saveWithUuid();
            }
        });
    }
}
