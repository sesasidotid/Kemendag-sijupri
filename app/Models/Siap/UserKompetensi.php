<?php

namespace App\Models\Siap;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserKompetensi extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_user_kompetensi';

    protected $fillable = [
        'name',
        'kategori',
        'nip',
        'tgl_mulai',
        'tgl_selesai',
        'tgl_sertifikat',
        'file_sertifikat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
