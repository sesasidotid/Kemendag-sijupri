<?php

namespace Eyegil\SijupriAkp\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriSiap\Models\JF;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Akp extends Updatable
{
    use HasFactory;

    protected $table = 'akp_akp';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string"])]
    private $nama_atasan;

    #[Column(["type" => "string"])]
    private $email_atasan;

    #[Column(["type" => "string", "index" => true])]
    private $nip;

    #[Column(["type" => "string", "nullable" => true])]
    private $rekomendasi;

    #[Column(["type" => "unsignedInteger", "foreign" => Instrument::class])]
    private $instrument_id;

    protected $fillable = ['id', 'nip', 'instrument_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function jf()
    {
        return $this->belongsTo(JF::class, "nip", "nip");
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, "instrument_id", "id");
    }

    public function matrixList()
    {
        return $this->hasMany(Matrix::class, "akp_id", "id")->orderBy("idx", "asc")->orderBy('kategori_instrument_id', 'asc');
    }
}
