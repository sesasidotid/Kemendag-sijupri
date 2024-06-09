<?php

namespace App\Models\Formasi;

use App\Models\Maintenance\Jenjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FormasiResult extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_formasi_result';

    protected $fillable = [
        'total',
        'sdm',
        'pembulatan',
        'result',
        'jenjang_code',
        'formasi_id',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }
}
