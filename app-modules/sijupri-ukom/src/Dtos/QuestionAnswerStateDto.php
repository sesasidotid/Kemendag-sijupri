<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class QuestionAnswerStateDto extends BaseDto
{
    public $question_id;
    public $is_answered;
    public $is_uncertain;
}
