<?php

namespace Eyegil\SecurityBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Updatable
{
    use HasFactory;
    protected $table = 'sec_device';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "nullable" => true])]
    private $device_model;

    #[Column(["type" => "string", "nullable" => true])]
    private $os_version;

    #[Column(["type" => "string", "nullable" => true])]
    private $app_version;

    #[Column(["type" => "string", "nullable" => true])]
    private $ip;

    #[Column(["type" => "string", "nullable" => true])]
    private $user_agent;

    #[Column(["type" => "string", "foreign" => Channel::class])]
    private $channel_code;

    #[Column(["type" => "string", "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $user_id;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_code', 'code');
    }
}
