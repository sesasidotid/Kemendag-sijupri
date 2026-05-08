<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExamGradeDto extends BaseDto
{
    public $id;
    public $exam_schedule_id;
    public $exam_type_code;
    public $room_ukom_id;
    public $participant_id;
    public $score;
    
    public $question_dto_list;

    public $kompetensi_indikator_dto_list;
}
