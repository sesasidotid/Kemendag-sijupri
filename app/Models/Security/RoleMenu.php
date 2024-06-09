<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RoleMenu extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_role_menu';

    protected $fillable = [
        'menu_code',
        'role_code',
    ];

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_code', 'code');
    }
}
