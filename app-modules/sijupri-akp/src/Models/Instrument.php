<?php

namespace Eyegil\SijupriAkp\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Eyegil\SijupriMaintenance\Models\JabatanJenjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instrument extends Metadata
{
    use HasFactory;

    protected $table = 'akp_instrument';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "text"])]
    protected $name;
    #[Column(["type" => "string", "foreign" => JabatanJenjang::class])]
    private $jabatan_jenjang_id;

    protected $fillable = ['id', 'jabatan_jenjang_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function jabatanJenjang()
    {
        return $this->belongsTo(JabatanJenjang::class, 'jabatan_jenjang_id', 'id');
    }

    public function kategoriInstrumentList()
    {
        return $this->hasMany(KategoriInstrument::class, 'instrument_id', 'id')->where('delete_flag', false);
    }
}
