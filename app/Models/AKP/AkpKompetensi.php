<?php

namespace App\Models\AKP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpKompetensi extends Model
{
    use HasFactory;

    protected $table = 'tbl_akp_kompetensi';

    protected $fillable = [
        'name',
        'description',
    ];

    public function akpKompetensiPelatihan()
    {
        return $this->hasMany(AkpKompetensiPelatihan::class);
    }
}
