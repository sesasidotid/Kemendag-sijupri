<?php

namespace Eyegil\NotificationBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Eyegil\SecurityBase\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationTopic extends Creatable
{
    use HasFactory;
    protected $table = 'not_topic';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $code;

    #[Column(["type" => "string"])]
    private $topic;

    #[Column(["type" => "string", "nullable" => true, "foreign" => Role::class, "cascade" => ["DELETE"]])]
    private $role_code;

    protected $fillable = ['id', 'topic'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function notificationSubscription()
    {
        return $this->hasMany(NotificationSubscription::class, 'notification_topic_code', 'code');
    }
}
