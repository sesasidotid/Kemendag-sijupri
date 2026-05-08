<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratRekomTemplate extends Updatable
{
    use HasFactory;

    protected $table = 'mnt_surat_rekom_template';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $code;
    #[Column(["type" => "text"])]
    private $base_template;
    #[Column(["type" => "text"])]
    private $template;

    protected $fillable = ['id', 'angka_kredit', 'jenjang_code', 'pangkat_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
