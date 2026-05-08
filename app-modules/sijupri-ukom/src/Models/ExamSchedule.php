<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSchedule extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_exam_schedule';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "timestamp"])]
    private $start_time;

    #[Column(["type" => "timestamp"])]
    private $end_time;

    #[Column(["type" => "float", "default" => 0])]
    private $duration;

    #[Column(["type" => "string", "nullable" => true])]
    private $secret_key;
    #[Column(["type" => "string", "foreign" => ExamType::class])]
    private $exam_type_code;



    #[Column(["type" => "integer", "default" => 1])]
    private $examiner_amount;



    #[Column(["type" => "string", "foreign" => RoomUkom::class, 'cascade' => ['DELETE']])]
    private $room_ukom_id;


    #[Column(["type" => "string", "foreign" => ExamSchedule::class, 'cascade' => ['DELETE']])]
    private $exam_schedule_parent_id;

    protected $fillable = ['id', 'start_time', 'end_time', 'exam_type_code', 'room_ukom_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function roomUkom()
    {
        return $this->belongsTo(RoomUkom::class, "room_ukom_id", "id");
    }

    public function examGradeList()
    {
        return $this->hasMany(ExamGrade::class, 'exam_type_code', 'exam_type_code')
            ->whereColumn('ukm_exam_grade.room_ukom_id', 'ukm_exam_schedule.room_ukom_id');
    }

    public function examQuestionList()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_schedule_id', 'id');
    }

    public function participantScheduleList()
    {
        return $this->hasMany(ParticipantSchedule::class, 'exam_schedule_id', 'id')
            ->orderBy("personal_schedule", 'asc');
    }

    public function participantSchedule($participant_id)
    {
        return $this->hasOne(ParticipantSchedule::class, 'exam_schedule_id', 'id')
            ->where('participant_id', $participant_id)->first();
    }

    public function examinerScheduleList()
    {
        return $this->hasMany(ExaminerSchedule::class, 'exam_schedule_id', 'id');
    }

    public function configuration()
    {
        return $this->hasOne(ExamConfiguration::class, 'exam_schedule_id', 'id');
    }

    public function examScheduleParent()
    {
        return $this->belongsTo(ExamSchedule::class, 'exam_schedule_parent_id', "id");
    }

    public function examScheduleChild()
    {
        return $this->hasOne(ExamSchedule::class, 'exam_schedule_parent_id', "id");
    }

    public function examAttendance()
    {
        return $this->hasMany(ExamAttendance::class, "exam_schedule_id", "id");
    }
}
