<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleMenu extends Creatable
{
    use HasFactory;
    protected $table = 'sec_role_menu';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => Role::class])]
    private $role_code;
    #[Column(["type" => "string", "foreign" => Menu::class])]
    private $menu_code;

    protected $fillable = ['id', 'role_code', 'menu_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_code', 'code');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_code', 'code');
    }
}
