<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Serializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginHistory extends Serializable
{
    use HasFactory;
    protected $table = 'sec_login_hist';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "timestamp"])]
    private $login_at;

    #[Column(["type" => "timestamp", "nullable" => true])]
    private $logouat_at;

    #[Column(["type" => "string", "foreign" => Device::class, "nullable" => true])]
    private $device_id;
}
