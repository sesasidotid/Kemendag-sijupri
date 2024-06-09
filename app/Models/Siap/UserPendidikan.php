<?php

namespace App\Models\Siap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserPendidikan extends Model
{
    use HasFactory, Notifiable;
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $table = 'tbl_user_pendidikan';
    protected $fillable = [
        'level',
        'jurusan',
        'instansi_pendidikan',
        'bulan_kelulusan',
        'ijazah'
    ];
}
