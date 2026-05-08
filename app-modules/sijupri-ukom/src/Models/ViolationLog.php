<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Serializable;
use Eyegil\SijupriUkom\Enums\ExamStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ViolationLog extends Serializable
{
    use HasFactory;

    protected $table = 'ukm_violation_log';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "nullable" => false])]
    private $remark;

    // new column
    #[Column(["type" => "string", "nullable" => false, "foreign" => ExamAttendance::class, 'cascade' => ['DELETE']])]
    private $exam_attendance_id;

    protected $fillable = ['id', 'remark', 'exam_attendance_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function examSchedule()
    {
        return $this->belongsTo(ExamAttendance::class, "exam_attendance_id", "id");
    }
}
