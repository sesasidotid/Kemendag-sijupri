<?php

namespace App\Enums;

enum NotificationTemplateCode: string
{
        //---siap---
    case NOTIFY_SIAP = "FCM_0001";
    case NOTIFY_VERIFY_SIAP = "FCM_0002";
    case NOTIFY_REJECT_SIAP = "FCM_0003";

        //---FORMASI---
    case NOTIFY_VERIFY_FORMASI = "FCM_0004";
    case NOTIFY_REJECT_FORMASI = "FCM_0005";
    case NOTIFY_INVITE_FORMASI = "FCM_0006";
    case NOTIFY_FINISH_FORMASI = "FCM_0007";

        //---FORMASI---
    case NOTIFY_VERIFY_UKOM = "FCM_0008";
    case NOTIFY_REJECT_UKOM = "FCM_0009";
    case NOTIFY_FINISH_UKOM = "FCM_0010";

        //---AKP---
    case NOTIFY_AKP_ATASAN = "SMTP_0001";
    case NOTIFY_VERIFY_AKP = "FCM_0011";
    case NOTIFY_AKP_PERSONAL = "FCM_0012";
    case NOTIFY_REJECT_AKP = "FCM_0013";
        //---UKOM---
    case NOTIFY_UKOM_REG_FINISHED = "SMTP_0002";
    case NOTIFY_UKOM_REG_NON_JF = "SMTP_0003";

        //---PASSWORD---
    case FORGOT_PASSWORD = "SMTP_0004";
}
