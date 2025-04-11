<?php

namespace Eyegil\SijupriSiap\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\Pangkat;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatPangkat extends Updatable
{
    use HasFactory;

    protected $table = 'siap_rw_pangkat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "date"])]
    private $tmt;
    #[Column(["type" => "string"])]
    private $sk_pangkat;
    #[Column(["type" => "string", "foreign" => Pangkat::class])]
    private $pangkat_code;
    #[Column(["type" => "string", "index" => true])]
    private $nip;

    protected $fillable = ['id', 'tmt', 'sk_pangkat', 'pangkat_code', 'nip'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class, 'pangkat_code', 'code');
    }

    public function jf()
    {
        return $this->belongsTo(JF::class, 'nip', 'nip');
    }
}
