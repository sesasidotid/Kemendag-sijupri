<?php

namespace Eyegil\EyegilLms\Services;

use Eyegil\EyegilLms\Dtos\QuestionDto;
use Eyegil\EyegilLms\Models\QuestionGroup;
use Illuminate\Support\Facades\DB;

class QuestionGroupService
{
    public function save(QuestionDto $questionDto)
    {
        return DB::transaction(function () use ($questionDto) {
            $userContext = user_context();

            $questionGroup = new QuestionGroup();
            $questionGroup->association = $questionDto->association;
            $questionGroup->association_id = $questionDto->association_id;
            $questionGroup->question_id = $questionDto->id;
            $questionGroup->created_by = $userContext->id;
            $questionGroup->saveWithUUid();
        });
    }
}
