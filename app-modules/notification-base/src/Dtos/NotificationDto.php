<?php

namespace Eyegil\NotificationBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class NotificationDto extends BaseDto
{
    public string $from;
    public $alias;
    public $cc;
    public $bcc;
    public $subject;
    public NotificationOptions $options;

    // for upload or any kind need to be attached on the email
    public $attachments;
    // for notification template
    public $objectMap;
    // for firebase and something that might needit
    public $additionalData;
}
