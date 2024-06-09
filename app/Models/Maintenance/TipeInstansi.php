<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TipeInstansi extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_tipe_instansi';

    protected $fillable = [
        'name',
        'description',
    ];
}
