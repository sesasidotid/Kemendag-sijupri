<?php

namespace Eyegil\EyegilLms\Dtos;

use Eyegil\Base\Dtos\BaseDto;


class AnswerDto extends BaseDto
{
    public $id;
    public $answer_text;
    public $answer_upload;
    public $answer_choice;
    public $participant_id;
    public $question_id;
    public $question_type;
    public $question;

    public function validateSaveMultipleChoice()
    {
        return $this->validate([
            "answer_choice" => "required|string",
            "participant_id" => "required|string",
            "question_id" => "required|string",
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            "id" => "required|string",
            "answer" => "required|string",
            "participant_id" => "required|string",
            "question_id" => "required|string",
        ]);
    }
}
