<?php

namespace App\Models\Siap;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserAbk extends Model
{
    use HasFactory, Notifiable;
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $table = 'tbl_user_abk';
    protected $fillable = [
    ];
}
