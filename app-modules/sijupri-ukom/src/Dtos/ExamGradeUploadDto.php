<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExamGradeUploadDto extends BaseDto
{
    public $file_mansoskul_grade;
    public $file_teknis_grade;
    public $room_ukom_id_list;

    public function validateUpload()
    {
        return $this->validate([
            "file_mansoskul_grade" => "required|string",
            "file_teknis_grade" => "required|string",
            "room_ukom_id_list" => "required",
        ]);
    }
}
