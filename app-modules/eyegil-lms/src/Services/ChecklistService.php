<?php

namespace Eyegil\EyegilLms\Services;

use Eyegil\EyegilLms\Dtos\ChecklistDto;
use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Models\Checklist;
use Illuminate\Support\Facades\DB;

class ChecklistService
{
    public function save(QuestionDto $questionDto)
    {
        return DB::transaction(function () use ($questionDto) {
            $userContext = user_context();

            foreach ($questionDto->checklist_dto_list as $key => $checklist_dto) {
                $checklistDto = (new ChecklistDto())->fromArray((array) $checklist_dto);

                $checklist = new Checklist();
                $checklist->fromArray($checklistDto->toArray());
                $checklist->created_by = $userContext->id;
                $checklist->question_id = $questionDto->id;
                $checklist->saveWithUuid();
            }
        });
    }
}
