<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 */
class AuthenticationType extends Creatable
{
    use HasFactory;
    protected $table = 'sec_authentication_type';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $code;
    #[Column(["type" => "string"])]
    private $name;
    #[Column(["type" => "string", "nullable" => true])]
    private $description;

    protected $fillable = ['code', 'name', 'description'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function applicationList()
    {
        return $this->hasMany(Application::class, 'authentication_type_code', 'code');
    }
}
