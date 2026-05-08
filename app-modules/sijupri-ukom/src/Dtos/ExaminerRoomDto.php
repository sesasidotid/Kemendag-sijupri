<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExaminerRoomDto extends BaseDto
{
    public $room_id;
    public $examiner_id_list;

    public function validateSave()
    {
        return $this->validate([
            "room_id" => "required|string",
            "examiner_id_list" => "required",
        ]);
    }
}
