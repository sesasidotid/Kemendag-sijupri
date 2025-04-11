<?php

namespace Eyegil\NotificationBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Creatable
{
    use HasFactory;
    protected $table = 'not_notification';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $code;

    #[Column(["type" => "string"])]
    private $name;

    protected $fillable = ['code', 'name'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
