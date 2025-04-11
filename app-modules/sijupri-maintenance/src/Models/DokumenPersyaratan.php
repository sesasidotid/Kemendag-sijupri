<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenPersyaratan extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_dokumen_persyaratan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "index" => true])]
    private $association;
    #[Column(["type" => "string", "nullable" => true])]
    private $additional_1;
    #[Column(["type" => "string", "nullable" => true])]
    private $additional_2;
    #[Column(["type" => "string", "nullable" => true])]
    private $additional_3;
    #[Column(["type" => "string", "nullable" => true])]
    private $additional_4;
    #[Column(["type" => "string", "nullable" => true])]
    private $additional_5;

    protected $fillable = ['id', 'association'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
