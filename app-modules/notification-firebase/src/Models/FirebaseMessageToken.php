<?php

namespace Eyegil\NotificationFirebase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SecurityBase\Models\Device;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FirebaseMessageToken extends Updatable
{
    use HasFactory;
    protected $table = 'not_fcm_token';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "index" => true])]
    private $token;
    #[Column(["type" => "string", "foreign" => Device::class])]
    private $device_id;

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}
