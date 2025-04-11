<?php

namespace Eyegil\SijupriSiap\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\PredikatKinerja;
use Eyegil\SijupriMaintenance\Models\RatingKinerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatKinerja extends Updatable
{
    use HasFactory;

    protected $table = 'siap_rw_kinerja';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $type;
    #[Column(["type" => "date"])]
    private $date_start;
    #[Column(["type" => "date"])]
    private $date_end;
    #[Column(["type" => "double"])]
    private $angka_kredit;
    #[Column(["type" => "string"])]
    private $doc_evaluasi;
    #[Column(["type" => "string"])]
    private $doc_predikat;
    #[Column(["type" => "string"])]
    private $doc_akumulasi_ak;
    #[Column(["type" => "string"])]
    private $doc_penetapan_ak;
    #[Column(["type" => "string", "foreign" => RatingKinerja::class])]
    private $rating_hasil_id;
    #[Column(["type" => "string", "foreign" => RatingKinerja::class])]
    private $rating_kinerja_id;
    #[Column(["type" => "string", "foreign" => PredikatKinerja::class])]
    private $predikat_kinerja_id;
    #[Column(["type" => "string", "index" => true])]
    private $nip;

    protected $fillable = ['id', 'type', 'date_start', 'date_end', 'angka_kredit', 'doc_evaluasi', 'doc_predikat', 'doc_akumulasi_ak', 'doc_penetapan_ak', 'rating_hasil_id', 'rating_kinerja_id', 'predikat_kinerja_id', 'nip'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function ratingHasil() {
        return $this->belongsTo(RatingKinerja::class, 'rating_hasil_id', 'id');
    }

    public function ratingKinerja() {
        return $this->belongsTo(RatingKinerja::class, 'rating_kinerja_id', 'id');
    }

    public function predikatKinerja() {
        return $this->belongsTo(PredikatKinerja::class, 'predikat_kinerja_id', 'id');
    }

    public function jf()
    {
        return $this->belongsTo(JF::class, 'nip', 'nip');
    }
}
