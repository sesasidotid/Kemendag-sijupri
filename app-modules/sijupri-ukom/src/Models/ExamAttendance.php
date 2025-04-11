<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Serializable;
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
    #[Column(["type" => "string", "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
    private $participant_ukom_id;
    #[Column(["type" => "string", "foreign" => Examtype::class])]
    private $exam_type_code;
    #[Column(["type" => "string", "foreign" => RoomUkom::class])]
    private $room_ukom_id;

    protected $fillable = ['id', 'start_at', 'finish_at', 'participant_ukom_id', 'exam_type_code', 'room_ukom_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function participantUkom()
    {
        return $this->belongsTo(ParticipantUkom::class, "participant_ukom", "id");
    }
    public function examType()
    {
        return $this->belongsTo(ExamType::class, "exam_type_code", "code");
    }
    public function roomUkom()
    {
        return $this->belongsTo(RoomUkom::class, "room_ukom_id", "id");
    }
}
