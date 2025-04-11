<?php

namespace Eyegil\NotificationBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class NotificationMessageDto extends BaseDto
{
    public $id;
    public $title;
    public $body;
    public $description;
    public $data;
    public $priority;
    public $read;
    public $expiry_date;
    public $user_id;
    public $notification_topic_code;
}
