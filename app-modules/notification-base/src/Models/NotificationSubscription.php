<?php

namespace Eyegil\NotificationBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Eyegil\SecurityBase\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationSubscription extends Creatable
{
    use HasFactory;
    protected $table = 'not_subscription';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "index" => true])]
    private $engine;

    #[Column(["type" => "string", "foreign" => User::class, 'cascade' => ['DELETE']])]
    private $user_id;

    #[Column(["type" => "string", "foreign" => NotificationTopic::class, 'cascade' => ['DELETE']])]
    private $notification_topic_code;

    protected $fillable = ['id', 'name', 'identifier', 'notification_topic_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function user()
    {
        return $this->belongsToMany(User::class, "user_id", 'id');
    }

    public function notificationTopic()
    {
        return $this->belongsToMany(NotificationTopic::class, "notification_topic_code", 'id');
    }
}
