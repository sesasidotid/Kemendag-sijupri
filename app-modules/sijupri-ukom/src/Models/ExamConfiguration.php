<?php

namespace Eyegil\SijupriUkom\Models;

use Deprecated;
use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamConfiguration extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_exam_config';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "nullable" => false, "foreign" => ExamSchedule::class, 'cascade' => ['DELETE']])]
    private $exam_schedule_id;

    protected $fillable = ['id', 'exam_schedule_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, 'exam_schedule_id', 'id');
    }

    public function examSuffleConfigurationList()
    {
        return $this->hasMany(ExamSuffleConfiguration::class, 'exam_configuration_id', 'id');
    }
}
