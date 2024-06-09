<?php

namespace App\Models\Siap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NilaiMansoskul extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_nilai_mansoskul';
    protected $fillable = [
        'integritas',
        'kerjasama',
        'komunikasi',
        'orientasi_hasil',
        'pelayanan_publik',
        'pengembangan_diri_orang_lain',
        'mengelola_perubahan',
        'pengambilan_keputusan',
        'perekat_bangsa',
        'jpm',
        'user_ukom_id'
    ];

    public function userUkom()
    {
        return $this->belongsTo(UserUkom::class);
    }
}
