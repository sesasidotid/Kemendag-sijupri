<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenjang extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_jenjang';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $code;

    #[Column(["type" => "string"])]
    private $kategori;

    protected $fillable = ['code', 'kategori'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
