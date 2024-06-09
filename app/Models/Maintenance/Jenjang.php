<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Jenjang extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_jenjang';

    protected $fillable = [
        'name',
        'description',
    ];
}
