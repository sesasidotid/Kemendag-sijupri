<?php

namespace App\Models\Ukom;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UkomRiwayat extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_ukom_riwayat';
    protected $fillable = [
        'periode_ukom',
        'jenis_ukom',
        'jenis_ujian',
        'tgl_cat',
        'hasil_cat',
        'nilai_cat',
        'tgl_wawancara',
        'hasil_wawancara',
        'nilai_wawancara',
        'tgl_praktek',
        'hasil_praktek',
        'nilai_praktek',
        'tgl_makala',
        'hasil_makala',
        'nilai_makala',
        'delete_flag',
        'inactive_flag',
        'task_status',
        'nip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
