<?php

namespace Eyegil\SijupriSiap\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SecurityBase\Models\User;
use Eyegil\SijupriMaintenance\Models\Instansi;
use Eyegil\SijupriMaintenance\Models\JenisKelamin;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserUnitKerja extends Updatable
{
    use HasFactory;

    protected $table = 'siap_user_unit_kerja';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true, "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $nip;
    #[Column(["type" => "string", "nullable" => true,  "foreign" => JenisKelamin::class])]
    private $jenis_kelamin_code;
    #[Column(["type" => "string", "nullable" => true, "foreign" => UnitKerja::class])]
    private $unit_kerja_id;

    protected $fillable = ['nip', 'jenis_kelamin_code', 'unit_kerja_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'id');
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function instansi()
    {
        return $this->hasOneThrough(Instansi::class, UnitKerja::class, 'id', 'id', 'unit_kerja_id', 'instansi_id');
    }
}
