<?php

namespace Eyegil\SijupriSiap\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatJabatan extends Updatable
{
    use HasFactory;

    protected $table = 'siap_rw_jabatan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "date"])]
    private $tmt;
    #[Column(["type" => "string"])]
    private $sk_jabatan;
    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $jabatan_code;
    #[Column(["type" => "string", "foreign" => Jenjang::class])]
    private $jenjang_code;
    #[Column(["type" => "string", "index" => true])]
    private $nip;

    protected $fillable = ['id', 'tmt', 'sk_jabatan', 'jabatan_code', 'jenjang_code', 'nip'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function jf()
    {
        return $this->belongsTo(JF::class, 'nip', 'nip');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }
}
