<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Creatable
{
    use HasFactory;
    protected $table = 'sec_user_role';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $user_id;
    #[Column(["type" => "string", "foreign" => Role::class, 'cascade' => ['DELETE']])]
    private $role_code;

    protected $fillable = ['id', 'user_id', 'role_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_code', 'code');
    }
}
