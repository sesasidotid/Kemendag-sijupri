<?php

namespace Eyegil\SijupriSiap\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\KategoriSertifikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatSertifikasi extends Updatable
{
    use HasFactory;

    protected $table = 'siap_rw_sertifikasi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "nullable" => true])]
    private $no_sk;
    #[Column(["type" => "date", "nullable" => true])]
    private $tgl_sk;
    #[Column(["type" => "string", "nullable" => true])]
    private $wilayah_kerja;
    #[Column(["type" => "date", "nullable" => true])]
    private $date_start;
    #[Column(["type" => "string", "nullable" => true])]
    private $date_end;
    #[Column(["type" => "string", "nullable" => true])]
    private $uu_kawalan;
    #[Column(["type" => "string"])]
    private $sk_pengangkatan;
    #[Column(["type" => "string", "nullable" => true])]
    private $ktp_ppns;
    #[Column(["type" => "string", "foreign" => KategoriSertifikasi::class])]
    private $kategori_sertifikasi_id;
    #[Column(["type" => "string", "index" => true])]
    private $nip;

    protected $fillable = ['id', 'no_sk', 'tgl_sk', 'wilayah_kerja', 'date_start', 'date_end', 'uu_kawalan', 'sk_pengangkatan', 'ktp_ppns', 'kategori_sertifikasi_id', 'nip'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function kategoriSertifikasi()
    {
        return $this->belongsTo(KategoriSertifikasi::class, 'kategori_sertifikasi_id', 'id');
    }

    public function jf()
    {
        return $this->belongsTo(JF::class, 'nip', 'nip');
    }
}
