<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExaminerUkomType extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_examiner_type';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "index" => true])]
    private $id;
    #[Column(["type" => "enum", 'enum' => ExamTypes::class])]
    private $exam_type;
    #[Column(["type" => "string", "foreign" => ExaminerUkom::class, 'cascade' => ['DELETE']])]
    private $examiner_id;

    protected $fillable = ['id', 'exam_type', 'examiner_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
    
    public function examiner()
    {
        return $this->belongsTo(ExaminerUkom::class, "examiner_id", "id");
    }
}
