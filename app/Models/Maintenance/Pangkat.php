<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pangkat extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_pangkat';

    protected $fillable = [
        'name',
        'description',
    ];
}
