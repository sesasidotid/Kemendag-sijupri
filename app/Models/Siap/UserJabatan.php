<?php

namespace App\Models\Siap;

use App\Models\Maintenance\Jabatan;
use App\Models\Maintenance\Jenjang;
use App\Models\Maintenance\Pangkat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserJabatan extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_user_jabatan';

    protected $fillable = [
        'tmt',
        'tipe_jabatan',
        'name',
        'sk_jabatan',
        'jabatan_code',
        'jenjang_code',
        'nip',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }
}
