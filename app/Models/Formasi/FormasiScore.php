<?php

namespace App\Models\Formasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FormasiScore extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_formasi_score';

    protected $fillable = [
        'main_id',
        'parent_id',
        'unsur',
        'volumen',
        'score',
        'lvl',
        'formasi_id',
        'jenjang_code',
        'formasi_unsur_id',
    ];
}
