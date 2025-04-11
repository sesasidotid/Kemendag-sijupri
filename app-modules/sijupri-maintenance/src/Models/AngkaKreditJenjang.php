<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AngkaKreditJenjang extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_angka_kredit_jenjang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "integer"])]
    private $angka_kredit;
    #[Column(["type" => "string", "foreign" => Jenjang::class])]
    private $jenjang_code;

    protected $fillable = ['id', 'angka_kredit', 'jenjang_code', 'pangkat_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, "jenjang_code", "code");
    }
}
