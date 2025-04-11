<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KabupatenKota extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_kabupaten_kota';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $keyType = 'string';

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $type;
    #[Column(["type" => "double"])]
    private $latitude;
    #[Column(["type" => "double"])]
    private $longitude;
    #[Column(["type" => "unsignedInteger", "foreign" => Provinsi::class])]
    private $provinsi_id;

    protected $fillable = ['id', 'type', 'latitude', 'longitude', 'provinsi_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id', 'id');
    }
}
