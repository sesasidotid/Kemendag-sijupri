<?php

namespace Eyegil\SijupriSiap\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\KategoriPengembangan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatKompetensi extends Updatable
{
    use HasFactory;

    protected $table = 'siap_rw_kompetensi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $name;
    #[Column(["type" => "date"])]
    private $date_start;
    #[Column(["type" => "date"])]
    private $date_end;
    #[Column(["type" => "date"])]
    private $tgl_sertifikat;
    #[Column(["type" => "string"])]
    private $sertifikat;
    #[Column(["type" => "string", "foreign" => KategoriPengembangan::class])]
    private $kategori_pengembangan_id;
    #[Column(["type" => "string", "index" => true])]
    private $nip;

    protected $fillable = ['id', 'type', 'date_start', 'date_end', 'tgl_sertifikat', 'sertifikat', 'kategori_pengembangan_id', 'nip'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function kategoriPengembangan()
    {
        return $this->belongsTo(KategoriPengembangan::class, 'kategori_pengembangan_id', 'id');
    }

    public function jf()
    {
        return $this->belongsTo(JF::class, 'nip', 'nip');
    }
}
