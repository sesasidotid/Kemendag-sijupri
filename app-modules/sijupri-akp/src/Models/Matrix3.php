<?php

namespace Eyegil\SijupriAkp\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matrix3 extends Updatable
{
    use HasFactory;

    protected $table = 'akp_matrix_3';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_waktu;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_kesulitan;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_kualitas;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_pengaruh;
    #[Column(["type" => "integer", "default" => 0])]
    private $score;
    #[Column(["type" => "unsignedInteger", "nullable" => true, "foreign" => Matrix::class, 'cascade' => ['DELETE']])]
    private $matrix_id;

    protected $fillable = ['id', 'nilai_waktu', 'nilai_kesulitan', 'nilai_kualitas', 'nilai_pengaruh', 'score', 'kategori', 'rank_prioritas', 'matrix_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function matrix()
    {
        $this->belongsTo(Matrix::class, 'matrix_id', 'id');
    }
}
