<?php

namespace App\Models;

use App\Models\Maintenance\Jabatan;
use App\Models\Siap\UserJabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PoinAK extends Model
{
    use HasFactory;
    protected $table = 'tbl_poin_angka_kredit';
    protected $fillable = [
        'user_id',
        'test_passed',
        'jabatan_id',
        'jenjang_id',
        'pangkat_id',
        'pangkat_id_terakhir',
        'ak_total',
        'ak_terbaru',
        'ak_terakhir',
        'rating',
        'pdf_dokumen_ak_terakhir',
        'pdf_hsl_evaluasi_kinerja',
        'pdf_akumulasi_ak_konversi',
        'approved',
        'max_standar_point',
        'max_jenjang',
        'max_pangkat',
        'max_pangkat_terakhir',
        'min_pangkat_terakhir',
        'selisih_pangkat',
        'selisih_jenjang',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_periodik',
        'status_selesai',
        'catatan',
        'pangkat_id_rekom'

    ];

    // Relationship with Jenjang model
    public function jenjang()
    {
        return $this->belongsTo(JenjangPangkat::class, 'jenjang_id');
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    // Relationship with Pangkat model
    public function pangkat()
    {
        return $this->belongsTo(PangkatGolongan::class, 'pangkat_id');
    }
    public function pangkatRekom()
    {
        return $this->belongsTo(PangkatGolongan::class, 'pangkat_id_rekom');
    }

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class, 'user_id');
    }
    public function riwayatJabatan()
    {
        return $this->belongsTo(UserJabatan::class, 'jenjang_id');
    }
}
