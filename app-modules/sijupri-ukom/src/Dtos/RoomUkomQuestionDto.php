<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class RoomUkomQuestionDto extends BaseDto
{
    public $id;
    public $exam_type_code;
    public $question_id_list;

    public function validateSave()
    {
        return $this->validate([
            "id" => "required|string",
            "exam_type_code" => "required|string",
            "question_id_list" => "required"
        ]);
    }
}
