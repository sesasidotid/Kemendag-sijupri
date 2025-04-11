<?php

namespace Eyegil\SijupriAkp\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matrix1 extends Updatable
{
    use HasFactory;

    protected $table = 'akp_matrix_1';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_ybs;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_atasan;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_rekan;
    #[Column(["type" => "integer", "default" => 0])]
    private $score;
    #[Column(["type" => "unsignedInteger", "nullable" => true, "foreign" => Matrix::class, 'cascade' => ['DELETE']])]
    private $matrix_id;

    protected $fillable = ['id', 'nilai_ybs', 'nilai_atasan', 'nilai_rekan', 'score', 'keterangan', 'matrix_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function matrix()
    {
        $this->belongsTo(Matrix::class, 'matrix_id', 'id');
    }
}
