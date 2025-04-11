<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instansi extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_instansi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "foreign" => InstansiType::class])]
    private $instansi_type_code;

    #[Column(["type" => "unsignedInteger", "nullable" => true, "foreign" => Provinsi::class])]
    private $provinsi_id;

    #[Column(["type" => "unsignedInteger", "nullable" => true, "foreign" => KabupatenKota::class])]
    private $kabupaten_id;

    #[Column(["type" => "unsignedInteger", "nullable" => true, "foreign" => KabupatenKota::class])]
    private $kota_id;

    protected $fillable = ['id', 'instansi_type_code', 'provinsi_id', 'kabupaten_id', 'kota_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function instansi()
    {
        return $this->belongsTo(InstansiType::class, 'instansi_type_code', 'code');
    }

    public function provinsi()
    {
        return $this->belongsTo(InstansiType::class, 'provinsi_id', 'code');
    }

    public function kabupaten()
    {
        return $this->belongsTo(InstansiType::class, 'kabupaten_id', 'code');
    }

    public function kota()
    {
        return $this->belongsTo(InstansiType::class, 'kota_id', 'code');
    }
}
