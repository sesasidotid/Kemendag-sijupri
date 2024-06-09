<?php

namespace App\Models\Siap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserPak extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_user_pak';
    protected $fillable = [
        'periode',
        'tgl_mulai',
        'tgl_selesai',
        'nilai_kinerja',
        'nilai_perilaku',
        'predikat',
        'angka_kredit',
        'pak',
        'file_doc_ak',
        'file_hasil_eval',
        'file_akumulasi_ak',
        'file_dok_konversi',
    ];
}
