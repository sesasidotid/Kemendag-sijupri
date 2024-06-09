<?php

namespace App\Models\AKP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpKompetensiPelatihan extends Model
{
    use HasFactory;

    protected $table = 'tbl_akp_kompetensi_pelatihan';

    protected $fillable = [
        'akp_kompetensi_id',
        'akp_pelatihan_id',
    ];

    public function akpKompetensiPelatihan()
    {
        return $this->belongsTo(AkpPertanyaan::class);
    }
}
