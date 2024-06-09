<?php

namespace App\Models\Siap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserAkp extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_user_akp';
    protected $fillable = [
        'name',
        'kategori',
        'end_date',
        'start_date',
        'nip',
    ];
}
