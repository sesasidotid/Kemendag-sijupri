<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\EyegilLms\Models\QuestionGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KompetensiIndikator extends Updatable
{
    use HasFactory;

    protected $table = 'mnt_kompetensi_indikator';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "text", "unique" => true, "index" => true])]
    private $code;

    #[Column(["type" => "text"])]
    private $name;

    #[Column(["type" => "string", "nullable" => "true", "foreign" => Kompetensi::class])]
    private $kompetensi_id;

    protected $fillable = ['id', 'code', 'type', 'jabatan_code', 'jenjang_code', 'bidang_jabatan_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function kompetensi()
    {
        return $this->belongsTo(Kompetensi::class, 'kompetensi_id', 'id');
    }

    public function questionGroup()
    {
        return $this->hasMany(QuestionGroup::class, 'association_id', 'id')->where("association", $this->table);
    }

}
