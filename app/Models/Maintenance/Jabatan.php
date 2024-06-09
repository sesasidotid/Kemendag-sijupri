<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Jabatan extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_jabatan';

    protected $fillable = [
        'code',
        'name',
        'description',
    ];
}
