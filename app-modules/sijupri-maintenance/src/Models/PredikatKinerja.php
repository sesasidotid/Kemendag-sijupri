<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PredikatKinerja extends Creatable
{
    use HasFactory;

    protected $table = 'mnt_predikat_kinerja';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string"])]
    private $name;

    #[Column(["type" => "integer"])]
    private $value;

    protected $fillable = ['id', 'name', 'value'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
