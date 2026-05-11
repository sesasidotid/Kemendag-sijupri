<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Serializable;
use Eyegil\SijupriUkom\Enums\ExamStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamAttendance extends Serializable
{
    use HasFactory;

    protected $table = 'ukm_exam_attendance';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "timestamp"])]
    private $start_at;

    #[Column(["type" => "timestamp", "nullable" => true])]
    private $finish_at;

    #[Column(["type" => "integer", "default" => 0])]
    private $violation_count;

    #[Column(["type" => "integer", "default" => 0])]
    private $mouse_away_count;

    #[Column(["type" => "string", "default" => ExamStatus::ONGOING->name, "nullable" => true, "enum" => ExamStatus::class])]
    private $status;

    #[Column(["type" => "string", "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
    private $participant_ukom_id;

    // new column
    #[Column(["type" => "string", "nullable" => false, "foreign" => ExamSchedule::class, 'cascade' => ['DELETE']])]
    private $exam_schedule_id;

    // #[Column(["type" => "string", "foreign" => Examtype::class])]
    // private $exam_type_code;

    // #[Column(["type" => "string", "foreign" => RoomUkom::class])]
    // private $room_ukom_id;

    protected $fillable = ['id', 'start_at', 'finish_at', 'participant_ukom_id', 'exam_type_code', 'room_ukom_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function participantUkom()
    {
        return $this->belongsTo(ParticipantUkom::class, "participant_ukom", "id");
    }

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, "exam_schedule_id", "id");
    }
}
