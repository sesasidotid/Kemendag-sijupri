<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provinsi extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_provinsi';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "double"])]
    private $latitude;
    #[Column(["type" => "double"])]
    private $longitude;
    #[Column(["type" => "string", "nullable" => true, "foreign" => Wilayah::class])]
    private $wilayah_code;

    protected $fillable = ['id', 'latitude', 'longitude', 'wilayah_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayag_code', 'code');
    }
}
