<?php

namespace Eyegil\SecurityPassword\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SecurityBase\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Password extends Updatable
{
    use HasFactory;
    protected $table = 'sec_pass_password';
    protected $primaryKey = 'user_id';
    public $incrementing = false;


    #[Column(["type" => "string", "primary" => true, "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $user_id;
    #[Column(["type" => "text"])]
    private $password;

    protected $fillable = ['user_id', 'password'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
