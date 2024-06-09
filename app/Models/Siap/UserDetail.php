<?php

namespace App\Models\Siap;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserDetail extends Model
{
    use HasFactory, Notifiable;
    protected $keyType = 'uuid';
    public $incrementing = false;
    
    protected $table = 'tbl_user_detail';
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
        'user_jabatan_id',
        'user_pangkat_id',
        'user_pendidikan_id',
        'user_akp_id',
        'user_pak_id',
    ];

    public function userJabatan()
    {
        return $this->belongsTo(UserJabatan::class);
    }

    public function userPangkat()
    {
        return $this->belongsTo(UserPangkat::class);
    }

    public function userPendidikan()
    {
        return $this->belongsTo(UserPendidikan::class);
    }

    public function userAkp()
    {
        return $this->belongsTo(UserAkp::class);
    }

    public function userPak()
    {
        return $this->belongsTo(UserPak::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
