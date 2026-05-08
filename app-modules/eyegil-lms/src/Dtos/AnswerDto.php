<?php

namespace Eyegil\EyegilLms\Dtos;

use Eyegil\Base\Dtos\BaseDto;


class AnswerDto extends BaseDto
{
    public $id;
    public $answer_text;
    public $answer_upload;
    public $answer_upload_url;
    public $file_answer_upload;
    public $answer_choice;
    public $answer_list;
    public $participant_id;
    public $question_id;
    public $question_type;
    public $question;
    public $is_uncertain;
    public $score;

    public function validateSave()
    {
        return $this->validate([
            "participant_id" => "required|string",
            "question_id" => "required|string",
        ]);
    }

    public function validateSaveMultipleChoice()
    {
        return $this->validate([
            "answer_choice" => "required|string",
            "participant_id" => "required|string",
            "question_id" => "required|string",
        ]);
    }

    public function validateSaveUpload()
    {
        return $this->validate([
            "file_answer_upload" => "required|string",
            "participant_id" => "required|string",
            "question_id" => "required|string",
        ]);
    }

    public function validateSaveEssay()
    {
        return $this->validate([
            "answer_text" => "required|string",
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
