<?php

namespace Eyegil\SijupriAkp\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Eyegil\SijupriMaintenance\Models\PelatihanTeknis;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriInstrument extends Metadata
{
    use HasFactory;

    protected $table = 'akp_kategori_instrument';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "text"])]
    protected $name;
    #[Column(["type" => "unsignedInteger", "foreign" => Instrument::class])]
    private $instrument_id;
    #[Column(["type" => "string", "nullable" => true, "foreign" => PelatihanTeknis::class])]
    private $pelatihan_teknis_id;

    protected $fillable = ['id', 'instrument_id', 'pelatihan_teknis_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id', 'id');
    }

    public function pertanyaanList()
    {
        return $this->hasMany(Pertanyaan::class, 'kategori_instrument_id', 'id')->where('delete_flag', false);
    }

    public function pelatihanTeknis()
    {
        return $this->belongsTo(PelatihanTeknis::class, 'pelatihan_teknis_id', 'id');
    }
}
