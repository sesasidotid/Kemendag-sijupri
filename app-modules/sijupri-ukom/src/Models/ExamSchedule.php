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
    #[Column(["type" => "string", "foreign" => ExamType::class])]
    private $exam_type_code;
    #[Column(["type" => "string", "foreign" => RoomUkom::class, 'cascade' => ['DELETE']])]
    private $room_ukom_id;

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
}
