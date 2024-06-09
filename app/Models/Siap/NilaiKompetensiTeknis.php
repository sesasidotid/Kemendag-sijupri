<?php

namespace App\Models\Siap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NilaiKompetensiTeknis extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_nilai_kompetensi_teknis';
    protected $fillable = [
        'cat',
        'wawancara',
        'praktik',
        'makala',
        'nilai_bobot',
        'user_ukom_id'
    ];

    public function userUkom()
    {
        return $this->belongsTo(UserUkom::class);
    }
}
