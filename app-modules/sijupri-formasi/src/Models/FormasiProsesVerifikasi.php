<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormasiProsesVerifikasi extends Updatable
{
    use HasFactory;

    protected $table = 'for_proses_verifikasi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "timestamp", "nullable" => true])]
    private $waktu_pelaksanaan;
    #[Column(["type" => "string"])]
    private $surat_undangan;
    #[Column(["type" => "string", "nullable" => true, "foreign" => Formasi::class])]
    private $formasi_id;

    protected $fillable = ['id', 'waktu_pelaksanaan', 'surat_undangan', 'formasi_id'];

    public function formasi()
    {
        return $this->belongsTo(Formasi::class, "formasi_id", "id");
    }
}
