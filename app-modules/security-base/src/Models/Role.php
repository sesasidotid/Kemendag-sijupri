<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Metadata
{
    use HasFactory;
    protected $table = 'sec_role';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $code;
    #[Column(["type" => "boolean", "default" => true])]
    private $creatable;
    #[Column(["type" => "boolean", "default" => true])]
    private $updatable;
    #[Column(["type" => "boolean", "default" => true])]
    private $deletable;
    #[Column(["type" => "string", "foreign" => Application::class])]
    private $application_code;

    protected $fillable = ['code', 'creatable', 'updatable', 'deletable', 'application_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_code', 'code');
    }

    public function roleMenuList()
    {
        return $this->hasMany(RoleMenu::class, 'role_code', 'code');
    }

    public function userRoleList()
    {
        return $this->hasMany(UserRole::class, 'role_code', 'code');
    }
}
