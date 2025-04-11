<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\DokumenPersyaratan;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentUkom extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_document';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $dokumen_name;
    #[Column(["type" => "string"])]
    private $jenis_ukom;
    #[Column(["type" => "string"])]
    private $dokumen;
    #[Column(["type" => "string", "foreign" => DokumenPersyaratan::class])]
    private $dokumen_persyaratan_id;
    #[Column(["type" => "string", "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
    private $participant_ukom_id;

    protected $fillable = ['id', 'dokumen_name', 'file', 'participant_ukom_id'];
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

    public function dokumenPersyaratan()
    {
        return $this->belongsTo(DokumenPersyaratan::class, 'dokumen_persyaratan_id', 'id');
    }
}
