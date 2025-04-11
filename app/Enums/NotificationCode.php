<?php

namespace App\Enums;

enum NotificationCode: string
{
    case SMTP = "smtp";
    case FIREBASE = "firebase";
}
