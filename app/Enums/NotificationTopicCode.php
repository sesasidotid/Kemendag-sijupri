<?php

namespace App\Enums;

enum NotificationTopicCode: string
{
    case VERIFY_SIAP = "VERIFY_SIAP";
    case VERIFY_SIAP_KINERJA = "VERIFY_SIAP_KINERJA";
    case VERIFY_AKP = "VERIFY_AKP";
    case VERIFY_FORMASI = "VERIFY_FORMASI";
    case INVITE_FORMASI = "INVITE_FORMASI";
    case REJECT_FORMASI = "REJECT_FORMASI";
    case VERIFY_UKOM = "VERIFY_UKOM";
}
