<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_detail';
    public $timestamps = false;
    protected $fillable = [
        'jenis_kelamin',
        'karpeg',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'email',
        'ktp',
        'nip',
        'jabatan_id',
        'jenjang_id',
        'pangkat_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function jenjang()
    {
        return $this->belongsTo(JenjangPangkat::class);
    }

    public function pangkat()
    {
        return $this->belongsTo(PangkatGolongan::class);
    }
}
