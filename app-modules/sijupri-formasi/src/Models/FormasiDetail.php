<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormasiDetail extends Updatable
{
    use HasFactory;

    protected $table = 'for_formasi_detail';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "integer", "default" => 0])]
    private $total;
    #[Column(["type" => "integer", "default" => 0])]
    private $result;
    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $jabatan_code;
    #[Column(["type" => "string", "foreign" => Formasi::class])]
    private $formasi_id;

    protected $fillable = ['id', 'total', 'result', 'jabatan_code', 'formasi_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function formasi()
    {
        return $this->belongsTo(Formasi::class, 'formasi_id', 'id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    public function formasiScoreList()
    {
        return $this->hasMany(FormasiScore::class, 'formasi_detail_id', 'id');
    }

    public function formasiResultList()
    {
        return $this->hasMany(FormasiResult::class, 'formasi_detail_id', 'id');
    }
}
