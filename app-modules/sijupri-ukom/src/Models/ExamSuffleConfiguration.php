<?php

namespace Eyegil\SijupriUkom\Models;

use Deprecated;
use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Eyegil\SijupriMaintenance\Models\KompetensiIndikator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSuffleConfiguration extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_exam_suffle_config';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "number", "nullable" => false])]

    private $num_of_question;

    #[Column(["type" => "string", "nullable" => false, "foreign" => ExamConfiguration::class, 'cascade' => ['DELETE']])]
    private $exam_configuration_id;

    #[Column(["type" => "string", "nullable" => false, "foreign" => KompetensiIndikator::class, 'cascade' => ['DELETE']])]

    private $kompetensi_indikator_id;

    protected $fillable = ['id', 'num_of_question', 'exam_configuration_id', 'exam_schedule_id', 'kompetensi_indikator_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function examConfiguration()
    {
        return $this->belongsTo(ExamConfiguration::class, 'exam_configuration_id', 'id');
    }

    public function kompetensiIndikator()
    {
        return $this->belongsTo(KompetensiIndikator::class, "kompetensi_indikator_id", "id");
    }
}
