<?php

namespace Eyegil\SijupriAkp\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matrix extends Creatable
{
    use HasFactory;

    protected $table = 'akp_matrix';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "nullable" => true])]
    private $relevansi;
    #[Column(["type" => "unsignedInteger", "nullable" => true, "foreign" => Pertanyaan::class])]
    private $pertanyaan_id;
    #[Column(["type" => "unsignedInteger", "nullable" => true, "foreign" => KategoriInstrument::class])]
    private $kategori_instrument_id;
    #[Column(["type" => "string", "foreign" => Akp::class, 'cascade' => ['DELETE']])]
    private $akp_id;

    protected $fillable = ['id', 'pertanyaan_id', 'kategori_instrument_id', 'akp_id', 'relevansi'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function akp()
    {
        return $this->belongsTo(Akp::class, 'akp_id', 'id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id', 'id');
    }

    public function kategoriInstrument()
    {
        return $this->belongsTo(KategoriInstrument::class, 'kategori_instrument_id', 'id');
    }

    public function matrix1()
    {
        return $this->hasOne(Matrix1::class, 'matrix_id', 'id');
    }

    public function matrix2()
    {
        return $this->hasOne(Matrix2::class, 'matrix_id', 'id');
    }

    public function matrix3()
    {
        return $this->hasOne(Matrix3::class, 'matrix_id', 'id');
    }

    public function akpRekap()
    {
        return $this->hasOne(AkpRekap::class, 'matrix_id', 'id');
    }
}
