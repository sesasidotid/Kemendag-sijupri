<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Eyegil\EyegilLms\Models\QuestionGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kompetensi extends Metadata
{
    use HasFactory;

    protected $table = 'mnt_kompetensi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "unique" => true, "index" => true])]
    private $code;

    #[Column(["type" => "string", "nullable" => true])]
    private $type;

    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $jabatan_code;

    #[Column(["type" => "string", "foreign" => Jenjang::class])]
    private $jenjang_code;

    #[Column(["type" => "string", "nullable" => "true", "foreign" => BidangJabatan::class])]
    private $bidang_jabatan_code;

    protected $fillable = ['id', 'code', 'type', 'jabatan_code', 'jenjang_code', 'bidang_jabatan_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }
    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }
    public function bidangJabatan()
    {
        return $this->belongsTo(BidangJabatan::class, 'bidang_jabatan_code', 'code');
    }

    public function questionGroup()
    {
        return $this->hasMany(QuestionGroup::class, 'association_id', 'id')->where("association", $this->table);
    }

}
