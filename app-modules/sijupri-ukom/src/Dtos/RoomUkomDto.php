<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class RoomUkomDto extends BaseDto
{
    public $id;
    public $name;
    public $jabatan_code;
    public $jabatan_name;
    public $jenjang_code;
    public $jenjang_name;
    public $bidang_jabatan_code;
    public $bidang_jabatan_name;
    public $participant_quota;
    public $exam_start_at;
    public $exam_end_at;
    public $vid_call_link;

    public $participant_dto_list;

    public $exam_schedule_dto_list;

    public function validateSave()
    {
        return $this->validate([
            "name" => "required|string",
            "jabatan_code" => "required|string",
            "jenjang_code" => "required|string",
            "participant_quota" => "required|integer",
            "exam_start_at" => "required",
            "exam_end_at" => "required",
            "vid_call_link" => "required",
        ]);
    }

    public function validateUpdate()
    {
        return $this->validate([
            'id' => 'required|string',
            'name' => 'required|string',
            'jabatan_code' => 'required|string',
            'jenjang_code' => 'required|string',
            'participant_quota' => 'required|integer',
            'exam_start_at' => 'required',
            'exam_end_at' => 'required',
            'vid_call_link' => 'required',
        ]);
    }

    public function validateSaveSchedule()
    {
        return $this->validate([
            'id' => 'required|string',
            'exam_schedule_dto_list' => 'required|array',
        ]);
    }
}
