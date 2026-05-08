<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class RoomUkomQuestionDto extends BaseDto
{
    public $id;
    public $exam_type_code;
    public $question_id_list;
    public $question;

    public function validateSave()
    {
        return $this->validate([
            "id" => "required|string",
            "exam_type_code" => "required|string",
        ]);
    }

    public function validateSaveCAT()
    {
        return $this->validate([
            "question_id_list" => "required"
        ]);
    }

    public function validateSaveMAKALAH()
    {
        return $this->validate([
            "question" => "required"
        ]);
    }
}
