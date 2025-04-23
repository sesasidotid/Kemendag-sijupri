<?php

namespace Eyegil\SijupriAkp\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriAkp\Enums\AkpRekapVerified;
use Eyegil\SijupriMaintenance\Models\PelatihanTeknis;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AkpRekap extends Updatable
{
    use HasFactory;

    protected $table = 'akp_rekap';
    protected $primaryKey = 'id';
    public $incrementing = true;

    #[Column(["type" => "unsignedInteger", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $keterangan;
    #[Column(["type" => "string"])]
    private $penyebab_diskrepansi_utama;
    #[Column(["type" => "string"])]
    private $jenis_pengembangan_kompetensi;
    #[Column(["type" => "string"])]
    private $kategori;
    #[Column(["type" => "string"])]
    private $rank_prioritas;
    #[Column(["type" => "string", "nullable" => true])]
    private $dokumen_verifikasi;
    #[Column(["type" => "string", "nullable" => true])]
    private $remark;
    #[Column(["type" => "string", "default" => AkpRekapVerified::EMPTY->value])]
    private $verified;
    #[Column(["type" => "string", "nullable" => true, "foreign" => PelatihanTeknis::class])]
    private $pelatihan_teknis_id;
    #[Column(["type" => "unsignedInteger", "foreign" => Matrix::class, 'cascade' => ['DELETE']])]
    private $matrix_id;

    protected $fillable = ['id', 'nilai_ybs', 'nilai_atasan', 'nilai_rekan', 'score', 'keterangan', 'matrix_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function matrix()
    {
        return $this->belongsTo(Matrix::class, 'matrix_id', 'id');
    }

    public function pelatihanTeknis()
    {
        return $this->belongsTo(PelatihanTeknis::class, 'pelatihan_teknis_id', 'id');
    }
}
