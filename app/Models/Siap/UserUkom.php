<?php

namespace App\Models\Siap;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserUkom extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_user_ukom';
    protected $fillable = [
        'periode',
        'jenis',
        'nilai_akhir',
        'file_rekomendasi',
        'nip'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
    public function nilaiMansoskul(){
        return $this->hasOne(NilaiMansoskul::class) ;
    }
    public function nilaiKontex(){
        return $this->hasOne(NilaiKompetensiTeknis::class) ;
    }

}
