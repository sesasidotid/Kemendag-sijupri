<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormasiResult extends Updatable
{
    use HasFactory;

    protected $table = 'for_formasi_result';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "double", "default" => 0])]
    private $total;
    #[Column(["type" => "double", "nullable" => true])]
    private $sdm;
    #[Column(["type" => "integer", "default" => 0])]
    private $pembulatan;
    #[Column(["type" => "double", "default" => 0])]
    private $result;
    #[Column(["type" => "string", "foreign" => Jenjang::class])]
    private $jenjang_code;
    #[Column(["type" => "string", "foreign" => FormasiDetail::class])]
    private $formasi_detail_id;

    protected $fillable = ['id', 'total', 'sdm', 'result', 'jenjang_code', 'formasi_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function formasiDetail()
    {
        return $this->belongsTo(FormasiDetail::class, "formasi_detail_id", "id");
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, "jenjang_code", "code");
    }
}
