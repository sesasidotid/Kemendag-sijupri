<?php

namespace Eyegil\EyegilLms\Dtos;

use Eyegil\Base\Dtos\BaseDto;


class MultipleChoiceDto extends BaseDto
{
    public $choice_id;
    public $choice_value;
    public $correct;
    public $question_id;
}
