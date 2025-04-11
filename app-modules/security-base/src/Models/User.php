<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SecurityBase\Enums\UserStatus;
use Eyegil\SecurityOauth2\Customs\UserPassportTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Updatable implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        MustVerifyEmail,
        HasFactory,
        Notifiable,
        HasApiTokens,
        UserPassportTrait;
    protected $table = 'sec_user';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $name;
    #[Column(["type" => "string", "nullable" => true])]
    private $email;
    #[Column(["type" => "string", "nullable" => true])]
    private $phone;
    #[Column(["type" => "enum", "default" => UserStatus::ACTIVE->name, 'enum' => UserStatus::class])]
    private $status;
    #[Column(["type" => "json", "nullable" => true])]
    private $user_details;

    protected $fillable = ['id', 'name', 'email', 'phone', 'status', 'user_details'];
    protected $casts = ['id' => 'string', 'user_details' => 'object'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function getAuthIdentifier()
    {
        return $this['id'];
    }

    public function userRoleList()
    {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }

    public function findForPassport($user_id)
    {
        return self::find($user_id);
    }

    public function userApplicationChannel()
    {
        return $this->hasMany(UserApplicationChannel::class, 'user_id', 'id');
    }
}
