<?php

namespace App\Models\Ukom;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UkomJadwal extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_ukom_jadwal';
    protected $fillable = [
        'created_by',
        'updated_by',
        'periode_ukom',
        'jenis_ukom',
        'jenis_ujian',
        'tgl_cat',
        'tgl_wawancara',
        'tgl_praktek',
        'tgl_makala',
        'task_status',
        'nip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
