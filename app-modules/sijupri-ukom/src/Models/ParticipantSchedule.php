<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParticipantSchedule extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_participant_schedule';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
    private $participant_id;
    #[Column(["type" => "string", "foreign" => ExamSchedule::class, 'cascade' => ['DELETE']])]
    private $exam_schedule_id;


    #[Column(["type" => "datetime", 'nullable' => true])]
    private $personal_schedule;


    #[Column(["type" => "datetime", 'nullable' => true])]
    private $personal_schedule_end;

    
    #[Column(["type" => "boolean", "default" => false])]
    private $examined;

    protected $fillable = ['id', 'participant_id', 'exam_schedule_id', 'personal_schedule'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function participantUkom()
    {
        return $this->belongsTo(ParticipantUkom::class, "participant_id", "id");
    }

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, "exam_schedule_id", "id");
    }

    public function examQuestionList($participant_id)
    {
        return $this->hasMany(ExamQuestion::class, 'exam_schedule_id', 'exam_schedule_id')
            ->where('participant_ukom_id', $participant_id)->get();
    }

    public function examAttendance($participant_id)
    {
        return $this->belongsTo(ExamAttendance::class, 'exam_schedule_id', 'exam_schedule_id')
            ->where('participant_ukom_id', $participant_id)
            ->first();
    }

    public function examScheduleSupervised()
    {
        return $this->hasOne(ExamScheduleSupervised::class, "participant_schedule_id", "id");
    }
}
