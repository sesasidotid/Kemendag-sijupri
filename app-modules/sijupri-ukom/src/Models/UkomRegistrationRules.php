<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Eyegil\SijupriMaintenance\Models\PredikatKinerja;
use Eyegil\SijupriMaintenance\Models\RatingKinerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UkomRegistrationRules extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_registration_rules';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "unique" => true, "foreign" => Jenjang::class])]
    private $jenjang_code;
    #[Column(["type" => "string"])]
    private $jenis_ukom;
    #[Column(["type" => "double", "default" => 0])]
    private $angka_kredit_threshold;
    #[Column(["type" => "integer", "default" => 1])]
    private $last_n_year;
    #[Column(["type" => "integer", "default" => 0])]
    private $tmt_last_n_year;
    #[Column(["type" => "string", "foreign" => RatingKinerja::class])]
    private $rating_hasil_id;
    #[Column(["type" => "string", "foreign" => RatingKinerja::class])]
    private $rating_kinerja_id;
    #[Column(["type" => "string", "foreign" => PredikatKinerja::class])]
    private $predikat_kinerja_id;


    protected $fillable = ['id', 'jenjang_code', 'angka_kredit_threshold', 'rating_hasil_id', 'rating_kinerja_id', 'predikat_kinerja_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, "jenjang_code", "code");
    }

    public function ratingHasil()
    {
        return $this->belongsTo(RatingKinerja::class, 'rating_hasil_id', 'id');
    }

    public function ratingKinerja()
    {
        return $this->belongsTo(RatingKinerja::class, 'rating_kinerja_id', 'id');
    }

    public function predikatKinerja()
    {
        return $this->belongsTo(PredikatKinerja::class, 'predikat_kinerja_id', 'id');
    }
}
