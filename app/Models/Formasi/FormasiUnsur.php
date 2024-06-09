<?php

namespace App\Models\Formasi;

use App\Models\Maintenance\Jabatan;
use App\Models\Maintenance\Jenjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FormasiUnsur extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_formasi_unsur';

    protected $fillable = [];

    public function formasiScore()
    {
        return $this->hasMany(FormasiScore::class)->where('delete_flag', false);
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }
}
