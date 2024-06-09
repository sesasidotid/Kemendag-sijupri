<?php

namespace App\Models\AKP;

use App\Models\AKP\PertanyaanAKP;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpKategoriPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'tbl_akp_kategori_pertanyaan';


    protected $fillable = [
        'kategori',
        'akp_instrumen_id',
    ];

    public function akpInstrumen()
    {
        return $this->belongsTo(AkpInstrumen::class, 'akp_instrumen_id', 'id');
    }

    public function akpPertanyaan()
    {
        return $this->hasMany(AkpPertanyaan::class)->where('delete_flag', false);
    }
}
