<?php

namespace App\Models\Ukom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UkomTeknis extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_ukom_teknis';
    protected $fillable = [
        'created_by',
        'cat',
        'wawancara',
        'seminar',
        'praktik',
        'makala',
        'nilai_bobot',
        'nb_cat',
        'nb_wawancara',
        'nb_seminar',
        'nb_praktik',
        'total_nilai_ukt',
        'nilai_ukt',
        'ukmsk',
        'nilai_akhir',
        'rekomendasi',
        'is_lulus',
    ];
}
