<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemConfiguration extends Updatable
{
    use HasFactory;

    protected $table = 'mnt_sys_conf';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $code;

    #[Column(["type" => "string"])]
    private $type;

    #[Column(["type" => "string"])]
    private $name;

    #[Column(["type" => "string"])]
    private $value;

    #[Column(["type" => "string"])]
    private $rule;

    protected $fillable = ['id', 'name', 'value'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
