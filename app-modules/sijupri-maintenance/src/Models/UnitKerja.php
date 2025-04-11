<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitKerja extends Updatable
{
    use HasFactory;

    protected $table = 'mnt_unit_kerja';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $name;
    #[Column(["type" => "string"])]
    private $email;
    #[Column(["type" => "string"])]
    private $phone;
    #[Column(["type" => "string"])]
    private $alamat;
    #[Column(["type" => "string", "nullable" => true])]
    private $file_rekomendasi_formasi;
    #[Column(["type" => "double"])]
    private $latitude;
    #[Column(["type" => "double"])]
    private $longitude;
    #[Column(["type" => "string", "foreign" => Instansi::class])]
    private $instansi_id;
    #[Column(["type" => "string", "foreign" => Wilayah::class])]
    private $wilayah_code;

    protected $fillable = ['id', 'name', 'operasional', 'email', 'phone', 'alamat', 'file_rekomendasi_formasi', 'latitude', 'longitude', 'instansi_id', 'wilayah_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, "instansi_id", "id");
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, "wilayah_code", "code");
    }
}
