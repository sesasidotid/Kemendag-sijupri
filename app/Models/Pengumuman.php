<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Pengumuman extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'judul',
        'isi',
    ];
    protected $table = 'tbl_pengumuman';
}
