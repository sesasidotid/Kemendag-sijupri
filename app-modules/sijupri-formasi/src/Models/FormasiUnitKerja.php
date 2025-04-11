<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriFormasi\Enums\FormasiStatus;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormasiUnitKerja extends Updatable
{
    use HasFactory;

    protected $table = 'for_formasi_unit_kerja';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $jabatan_code;
    #[Column(["type" => "string", "foreign" => UnitKerja::class])]
    private $unit_kerja_id;

    protected $fillable = ['id', 'jabatan', 'unit_kerja_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }
}
