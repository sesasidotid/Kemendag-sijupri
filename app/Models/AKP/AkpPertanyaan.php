<?php

namespace App\Models\AKP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'tbl_akp_pertanyaan';

    protected $fillable = [
        'akp_kategori_pertanyaan_id',
        'pertanyaan'
    ];

    public function akpKategoriPertanyaan()
    {
        return $this->belongsTo(AkpKategoriPertanyaan::class);
    }
}
