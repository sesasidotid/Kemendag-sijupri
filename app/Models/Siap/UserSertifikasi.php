<?php

namespace App\Models\Siap;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserSertifikasi extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_user_sertifikasi';

    protected $fillable = [
        'kategori',
        'nomor_sk',
        'tanggal_sk',
        //Penyidik Pegawai Negeri Sipil (PPNS)
        'wilayah_kerja',
        'berlaku_mulai',
        'berlaku_sampai',
        'file_doc_sk',
        'file_ktp_ppns',
        'uu_kawalan',
        
        'nip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
