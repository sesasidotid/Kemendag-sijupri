<?php

namespace Eyegil\SijupriAkp\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matrix2 extends Updatable
{
    use HasFactory;

    protected $table = 'akp_matrix_2';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_penugasan;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_materi;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_informasi;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_standar;
    #[Column(["type" => "integer", "default" => 0])]
    private $nilai_metode;
    #[Column(["type" => "integer", "default" => 0])]
    private $score;
    #[Column(["type" => "string", "nullable" => true])]
    private $alasan_materi;
    #[Column(["type" => "string", "nullable" => true])]
    private $alasan_informasi;
    #[Column(["type" => "unsignedInteger", "nullable" => true, "foreign" => Matrix::class, 'cascade' => ['DELETE']])]
    private $matrix_id;

    protected $fillable = ['id', 'nilai_penugasan', 'nilai_materi', 'nilai_informasi', 'nilai_standar', 'nilai_metode', 'score', 'alasan_materi', 'alasan_informasi', 'penyebab_diskrepansi_utama', 'jenis_pengembangan_kompetensi', 'matrix_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function matrix()
    {
        $this->belongsTo(Matrix::class, 'matrix_id', 'id');
    }
}
