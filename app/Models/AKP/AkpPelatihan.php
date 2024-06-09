<?php

namespace App\Models\AKP;

use App\Models\Maintenance\Jabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkpPelatihan extends Model
{
    use HasFactory;

    protected $table = 'tbl_akp_pelatihan';

    protected $fillable = [
        'name',
        'description',
        'jabatan_code'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    public function akpKompetensiPelatihan()
    {
        return $this->hasMany(AkpKompetensiPelatihan::class);
    }
}
