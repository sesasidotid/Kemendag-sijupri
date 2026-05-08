<?php

namespace Eyegil\EyegilLms\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Eyegil\EyegilLms\Enums\QuestionType;

class QuestionDto extends BaseDto
{
    public $id;
    public $question;
    public $type;
    public $file_attachment;
    public $attachment;
    public $attachment_url;
    public $module_id;
    public $association_id;
    public $association;
    public $group_id;
    public $weight;
    public $hint;
    public $parent_question_id;

    public $multiple_choice_dto_list;

    public $checklist_dto_list;

    public $answer_dto;

    public $kompetensi_indikator_id;
    public $kompetensi_indikator_name;

    public function validateSave()
    {
        $this->validate([
            "question" => "required|string",
            "type" => "required|string",
            "module_id" => "required|string",
        ]);

        if ($this->type == QuestionType::MULTI_CHOICE) {
            return $this->validate(["multiple_choice_dto_list" => "required",]);
        }

        return $this;
    }

    public function validateUpdate()
    {
        $this->validate([
            "id" => "required|string",
            "question" => "required|string",
            "type" => "required|string",
            "metadata" => "required",
            "module_id" => "required|string",
        ]);

        if ($this->type == QuestionType::MULTI_CHOICE) {
            return $this->validate(["multiple_choice_dto_list" => "required",]);
        }

        return $this;
    }
}
