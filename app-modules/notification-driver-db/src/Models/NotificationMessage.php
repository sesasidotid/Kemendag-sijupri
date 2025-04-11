<?php

namespace Eyegil\NotificationDriverDb\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Eyegil\NotificationBase\Models\NotificationTopic;
use Eyegil\SecurityBase\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationMessage extends Creatable
{
    use HasFactory;
    protected $table = 'not_message';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string"])]
    private $title;

    #[Column(["type" => "string"])]
    private $body;

    #[Column(["type" => "json", "nullable" => true])]
    private $data;

    #[Column(["type" => "integer", 'default' => 0])]
    private $priority;

    #[Column(["type" => "integer", 'default' => 0])]
    private $read;

    #[Column(["type" => "string"])]
    private $expiry_date;

    #[Column(["type" => "string", "nullable" => true, "foreign" => User::class])]
    private $user_id;

    #[Column(["type" => "string", "nullable" => true, "foreign" => NotificationTopic::class])]
    private $notification_topic_code;

    protected $fillable = ['id', 'body', 'data'];
    protected $cast = ['data' => 'object'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function notificationTopic()
    {
        return $this->belongsTo(NotificationTopic::class, 'notification_topic_code', 'code');
    }
}
