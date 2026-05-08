<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\DokumenPersyaratan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentUkom extends Updatable
{
    use HasFactory;

    protected $table = 'for_definis_operasional';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $name;
    #[Column(["type" => "float"])]
    private $skr;

    #[Column(["type" => "string", "foreign" => RuangLingkup::class])]
    private $ruang_lingkup_id;

    protected $fillable = ['id', 'name', 'ruang_lingkup_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
