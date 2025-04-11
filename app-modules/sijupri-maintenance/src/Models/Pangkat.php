<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pangkat extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_pangkat';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $code;

    #[Column(["type" => "string"])]
    private $golongan;

    protected $fillable = ['code', 'golongan'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
