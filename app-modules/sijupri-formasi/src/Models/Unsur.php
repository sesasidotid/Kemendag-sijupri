<?php

namespace Eyegil\SijupriFormasi\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unsur extends Updatable
{
    use HasFactory;

    protected $table = 'for_unsur';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "text"])]
    private $unsur;
    #[Column(["type" => "string", "nullable" => true])]
    private $standart_waktu;
    #[Column(["type" => "string", "nullable" => true])]
    private $satuan_waktu;
    #[Column(["type" => "string", "nullable" => true])]
    private $satuan_hasil;
    #[Column(["type" => "double", "nullable" => true])]
    private $standart_hasil;
    #[Column(["type" => "double", "nullable" => true])]
    private $luas;
    #[Column(["type" => "double", "nullable" => true])]
    private $angka_kredit;
    #[Column(["type" => "double", "nullable" => true])]
    private $konstanta;
    #[Column(["type" => "integer", "nullable" => true])]
    private $lvl;
    #[Column(["type" => "string", "nullable" => true, "foreign" => Jenjang::class])]
    private $jenjang_code;
    #[Column(["type" => "string", "nullable" => true, "foreign" => Jabatan::class])]
    private $jabatan_code;
    #[Column(["type" => "unsignedInteger", "nullable" => true, "index" => true])]
    private $parent_id;

    protected $fillable = ['id', 'unsur', 'standart_waktu', 'satuan_waktu', 'satuan_hasil', 'standart_hasil', 'luas', 'angka_kredit', 'konstanta', 'lvl', 'jenjang_code', 'jabatan_code', 'parent_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function parent()
    {
        return $this->belongsTo(Unsur::class, 'parent_id', 'id');
    }

    public function child()
    {
        return $this->hasMany(Unsur::class, 'parent_id', 'id');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    public function formasiScore()
    {
        return $this->hasMany(FormasiScore::class, 'unsur_id', 'id');
    }
}
