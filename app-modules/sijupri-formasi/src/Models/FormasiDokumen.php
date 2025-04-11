<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\DokumenPersyaratan;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormasiDokumen extends Updatable
{
    use HasFactory;

    protected $table = 'for_formasi_dokumen';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $dokumen;
    #[Column(["type" => "string", "foreign" => DokumenPersyaratan::class])]
    private $dokumen_persyaratan_id;
    #[Column(["type" => "string", "foreign" => Formasi::class])]
    private $formasi_id;

    protected $fillable = ['id', 'dokumen_name', 'dokumen', 'unit_kerja_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function dokumenPersyaratan()
    {
        return $this->belongsTo(DokumenPersyaratan::class, "dokumen_persyaratan_id", "id");
    }
}
