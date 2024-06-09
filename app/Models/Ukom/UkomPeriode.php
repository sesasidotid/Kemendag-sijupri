<?php

namespace App\Models\Ukom;

use App\Models\Messaging\Announcement;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UkomPeriode extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_ukom_periode';
    protected $fillable = [
        'periode',
        'tgl_mulai_pendaftaran',
        'tgl_tutup_pendaftaran',
        'inactive_flag',
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }
}
