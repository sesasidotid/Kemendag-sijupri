<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AngkaKreditPangkat extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_angka_kredit_pangkat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "integer"])]
    private $angka_kredit;
    #[Column(["type" => "string", "foreign" => Pangkat::class])]
    private $pangkat_code;

    protected $fillable = ['id', 'angka_kredit', 'jenjang_code', 'pangkat_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class, "pangkat_code", "code");
    }
}
