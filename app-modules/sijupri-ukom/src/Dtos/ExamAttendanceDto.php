<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExamAttendanceDto extends BaseDto
{
    public $start_at;
    public $finish_at;
    public $participant_ukom_id;
    public $exam_schedule_id;

    public $status;
}
