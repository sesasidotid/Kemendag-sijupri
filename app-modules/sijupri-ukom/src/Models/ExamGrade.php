<?php

namespace Eyegil\SijupriUkom\Models;

use Deprecated;
use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamGrade extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_exam_grade';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "double", "nullable" => true])]
    private $score;

    #[Column(["type" => "string", "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
    private $participant_id;

    // new column
    #[Column(["type" => "string", "nullable" => false, "foreign" => ExamSchedule::class, 'cascade' => ['DELETE']])]
    private $exam_schedule_id;

    // new column
    #[Column(["type" => "boolean", "default" => false])]
    private $inactive_flag;

    // waiting for remove
    // #[Deprecated]
    // #[Column(["type" => "string", "foreign" => ExamType::class])]
    // private $exam_type_code;

    // #[Deprecated]
    // #[Column(["type" => "string", "foreign" => RoomUkom::class])]
    // private $room_ukom_id;

    protected $fillable = ['id', 'exam_type_code', 'room_ukom_id', 'participant_id', 'score'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function participant()
    {
        return $this->belongsTo(ParticipantUkom::class, 'participant_id', 'id');
    }

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, 'exam_schedule_id', 'id');
    }
}
