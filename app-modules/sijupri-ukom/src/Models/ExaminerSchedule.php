<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExaminerSchedule extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_examiner_schedule';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => ExaminerUkom::class, 'cascade' => ['DELETE']])]
    private $examiner_id;
    #[Column(["type" => "string", "foreign" => ExamSchedule::class, 'cascade' => ['DELETE']])]
    private $exam_schedule_id;

    protected $fillable = ['id', 'examiner_id', 'exam_schedule_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
    
    public function examinerUkom()
    {
        return $this->belongsTo(ExaminerUkom::class, "examiner_id", "id");
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

    public function examScheduleSupervised()
    {
        return $this->hasMany(ExamScheduleSupervised::class, "examiner_schedule_id", "id");
    }
}
