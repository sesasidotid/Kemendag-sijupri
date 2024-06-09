<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoinKoefisienPerformance extends Model
{
    use HasFactory;
    protected $table = 'tbl_koefisien_poin_performance';

    protected $fillable = ['jenjang_id', 'pangkat_id', 'max_standar_point'];
    public $timestamps = false;

    public function jenjangPangkat()
    {
        return $this->belongsTo(JenjangPangkat::class, 'jenjang_id');
    }

    public function pangkatGolongan()
    {
        return $this->belongsTo(PangkatGolongan::class, 'pangkat_id');
    }
}
