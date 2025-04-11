<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormasiScore extends Creatable
{
    use HasFactory;

    protected $table = 'for_formasi_score';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "double", "nullable" => true])]
    private $value;
    #[Column(["type" => "double", "nullable" => true])]
    private $score;
    #[Column(["type" => "unsignedInteger", "foreign" => Unsur::class])]
    private $unsur_id;
    #[Column(["type" => "string", "foreign" => FormasiDetail::class])]
    private $formasi_detail_id;

    protected $fillable = ['id', 'value', 'score', 'unsur_id', 'formasi_detail_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
