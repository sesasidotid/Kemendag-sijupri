<?php

namespace App\Models\Ukom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UkomMansoskul extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_ukom_mansoskul';
    protected $fillable = [
        'created_by',
        'integritas',
        'kerjasama',
        'komunikasi',
        'orientasi_hasil',
        'pelayanan_publik',
        'pengembangan_diri_orang_lain',
        'mengelola_perubahan',
        'pengambilan_keputusan',
        'perekat_bangsa',
        'score',
        'jpm',
        'kategori',
    ];
}
