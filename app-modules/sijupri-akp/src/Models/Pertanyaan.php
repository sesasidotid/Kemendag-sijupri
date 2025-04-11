<?php

namespace Eyegil\SijupriAkp\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pertanyaan extends Metadata
{
    use HasFactory;

    protected $table = 'akp_pertanyaan';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;

    #[Column(["type" => "unsignedInteger", "foreign" => KategoriInstrument::class])]
    private $kategori_instrument_id;
    #[Column(["type" => "text"])]
    protected $name;

    protected $fillable = ['id', 'kategori_instrument_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function kategoriInstrument()
    {
        $this->belongsTo(KategoriInstrument::class, 'kategori_instrument_id', 'code');
    }
}
