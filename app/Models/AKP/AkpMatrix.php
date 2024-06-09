<?php

namespace App\Models\AKP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpMatrix extends Model
{
    use HasFactory;

    protected $table = 'tbl_akp_matrix';

    protected $fillable = [
        //matrix 1
        'ybs',
        'atasan',
        'rekan',
        'score_matrix_1',
        'keterangan_matrix_1',
        //matrix 2
        'penugasan',
        'materi',
        'alasan_materi',
        'informasi',
        'alasan_informasi',
        'standar',
        'metode',
        'penyebab_diskrepansi_utama',
        'jenis_pengembangan_kompetensi',
        //matrix 3
        'waktu',
        'kesulitan',
        'kualitas',
        'pengaruh',
        'score_matrix_3',
        'rank_prioritas_matrix_3',
        //
        'akp_pertanyaan_id',
        'akp_id',

        'akp_pelatihan_id',
    ];

    public function akp()
    {
        return $this->belongsTo(Akp::class, 'akp_id', 'id');
    }

    public function pertanyaanAKP()
    {
        return $this->belongsTo(AkpPertanyaan::class, 'akp_pertanyaan_id', 'id');
    }

    public function akpPelatihan()
    {
        return $this->belongsTo(AkpPelatihan::class);
    }
}
