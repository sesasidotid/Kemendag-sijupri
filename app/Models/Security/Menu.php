<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Menu extends Model
{
    use HasFactory, Notifiable;
    public $incrementing = false;
    protected $table = 'tbl_menu';

    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_code'
    ];

    public function child()
    {
        return $this->hasMany(Menu::class, 'parent_code', 'code');
    }

    public function roleMenu()
    {
        return $this->hasMany(RoleMenu::class, 'menu_code', 'code');
    }

    public function existingChild()
    {
        $userContext = auth()->user();
        return $this->hasMany(Menu::class, 'parent_code', 'code')->whereHas('roleMenu', function ($query) use ($userContext) {
            $query->where('role_code', $userContext->role_code);
        })->orderBy('idx', 'ASC');
    }
}
