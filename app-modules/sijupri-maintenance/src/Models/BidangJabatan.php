<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BidangJabatan extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_bidang_jabatan';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $code;
    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $jabatan_code;

    protected $fillable = ['code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
