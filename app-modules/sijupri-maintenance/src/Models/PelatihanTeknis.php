<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PelatihanTeknis extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_pelatihan_teknis';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "index" => true])]
    private $code;
    #[Column(["type" => "string", "index" => true])]
    private $type;
    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $jabatan_code;

    protected $fillable = ['id', 'code', 'type', 'jabatan_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, "jabatan_code", "code");
    }
}
