<?php

namespace App\Models\AKP;

use App\Models\Maintenance\Jabatan;
use App\Models\Maintenance\Jenjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpInstrumen extends Model
{
    use HasFactory;

    protected $table = 'tbl_akp_instrumen';
    

    protected $fillable = [
        'nama',
        'deskripsi',
        'jabatan_code',
        'jenjang_code',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    public function akpKategoriPertanyaan(){
        return $this->hasMany(AkpKategoriPertanyaan::class, 'akp_instrumen_id', 'id')->where('delete_flag', false);
    }
}
