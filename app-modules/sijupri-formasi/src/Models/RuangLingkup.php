<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\DokumenPersyaratan;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuangLingkup extends Updatable
{
    use HasFactory;

    protected $table = 'for_ruang_lingkup';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $name;

    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $jabatan_code;

    protected $fillable = ['id', 'name', 'jabatan_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
