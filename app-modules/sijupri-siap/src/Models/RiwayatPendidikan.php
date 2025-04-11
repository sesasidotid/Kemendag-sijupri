<?php

namespace Eyegil\SijupriSiap\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\Pendidikan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatPendidikan extends Updatable
{
    use HasFactory;

    protected $table = 'siap_rw_pendidikan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $institusi_pendidikan;
    #[Column(["type" => "string"])]
    private $jurusan;
    #[Column(["type" => "date"])]
    private $tanggal_ijazah;
    #[Column(["type" => "string"])]
    private $ijazah;
    #[Column(["type" => "string", "foreign" => Pendidikan::class])]
    private $pendidikan_code;
    #[Column(["type" => "string", "index" => true])]
    private $nip;

    protected $fillable = ['id', 'institusi_pendidikan', 'jurusan', 'tanggal_ijazah', 'ijazah', 'pendidikan_code', 'nip'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_code', 'code');
    }

    public function jf()
    {
        return $this->belongsTo(JF::class, 'nip', 'nip');
    }
}
