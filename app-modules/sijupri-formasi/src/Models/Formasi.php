<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriFormasi\Enums\FormasiStatus;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formasi extends Updatable
{
    use HasFactory;

    protected $table = 'for_formasi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "nullable" => true])]
    private $rekomendasi;
    #[Column(["type" => "string", "default" => FormasiStatus::PENDING->value])]
    private $formasi_status;
    #[Column(["type" => "string", "foreign" => UnitKerja::class])]
    private $unit_kerja_id;

    protected $fillable = ['id', 'rekomendasi', 'formasi_status', 'unit_kerja_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function formasiDetailList()
    {
        return $this->hasMany(FormasiDetail::class, 'formasi_id', 'id');
    }

    public function formasiDokumenList()
    {
        return $this->hasMany(FormasiDokumen::class, 'formasi_id', 'id');
    }
}
