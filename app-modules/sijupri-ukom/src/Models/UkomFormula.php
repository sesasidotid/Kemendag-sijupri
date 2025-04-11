<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Eyegil\EyegilLms\Models\QuestionGroup;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UkomFormula extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_formula';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $jabatan_code;
    #[Column(["type" => "string", "foreign" => Jenjang::class])]
    private $jenjang_code;
    #[Column(["type" => "double", "default" => 100])]
    private $cat_percentage;
    #[Column(["type" => "double", "default" => 100])]
    private $wawancara_percentage;
    #[Column(["type" => "double", "default" => 100])]
    private $seminar_percentage;
    #[Column(["type" => "double", "default" => 100])]
    private $praktik_percentage;
    #[Column(["type" => "double", "default" => 100])]
    private $portofolio_percentage;
    #[Column(["type" => "double", "default" => 100])]
    private $ukt_percentage;
    #[Column(["type" => "double", "default" => 100])]
    private $ukmsk_percentage;
    #[Column(["type" => "double", "default" => 0])]
    private $grade_threshold;
    #[Column(["type" => "double", "default" => 0])]
    private $ukt_threshold;
    #[Column(["type" => "double", "default" => 0])]
    private $jpm_threshold;

    protected $fillable = ['id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, "jabatan_code", "code");
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, "jenjang_code", "code");
    }
}
