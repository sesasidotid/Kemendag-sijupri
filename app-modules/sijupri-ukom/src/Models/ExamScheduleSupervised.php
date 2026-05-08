<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamScheduleSupervised extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_exam_schedule_supervised';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "foreign" => ParticipantSchedule::class, 'cascade' => ['DELETE']])]
    private $participant_schedule_id;
    #[Column(["type" => "string", "foreign" => ExaminerSchedule::class, 'cascade' => ['DELETE']])]
    private $examiner_schedule_id;

    protected $fillable = ['id', 'start_time', 'participant_schedule_id', 'examiner_schedule_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function participantSchedule()
    {
        return $this->belongsTo(ParticipantSchedule::class, "participant_schedule_id", "id");
    }

    public function examinerSchedule()
    {
        return $this->belongsTo(ExaminerSchedule::class, "examiner_schedule_id", "id");
    }
}
