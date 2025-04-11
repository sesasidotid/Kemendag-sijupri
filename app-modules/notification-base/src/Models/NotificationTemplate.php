<?php

namespace Eyegil\NotificationBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationTemplate extends Creatable
{
    use HasFactory;
    protected $table = 'not_template';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    #[Column(["type" => "string", "primary" => true])]
    private $code;
    #[Column(["type" => "text"])]
    private $template;
    #[Column(["type" => "string", "nullable" => true, "index" => true])]
    private $parent_code;
    #[Column(["type" => "string", "foreign" => Notification::class])]
    private $notification_code;

    protected $fillable = ['code', 'template', 'parent_code', 'notification_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_code', 'code');
    }

    public function parent()
    {
        return $this->belongsTo(NotificationTemplate::class, 'parent_code', 'code');
    }

    public function child()
    {
        return $this->hasMany(NotificationTemplate::class, 'parent_code', 'code');
    }
}
