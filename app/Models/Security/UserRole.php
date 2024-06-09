<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserRole extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_user_role';

    protected $fillable = [
        'nip',
        'role_code',
    ];
}
