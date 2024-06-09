<?php

namespace App\Models\AKP;

use App\Models\Maintenance\Jabatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Akp extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_akp';

    protected $fillable = [
        'nama_atasan',
        'jabatan_atasan',
        'unit_kerja',
        'alamat_unit_kerja',
        'phone_unit_kerja',
        'tahun_kelulusan',
        'nip',
        'akp_instrumen_id',
        'pangkat_id',
        'jabatan_code',
        'nama_jabatan',
        'tanggal_mulai',
        "tanggal_selesai",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    public function akpInstrumen()
    {
        return $this->belongsTo(AkpInstrumen::class);
    }

    public function akpMatrix()
    {
        return $this->hasMany(AkpMatrix::class, 'akp_id', 'id');
    }
}
