<?php

namespace Eyegil\NotificationBase\Services;

use Eyegil\NotificationBase\Dtos\NotificationDto;

interface INotificationService
{
    public function subscribe($topic_code, $identifier);
    public function unsubscribe($topic_code, $identifier);

    public function sendToTopic($notification_topic_code, NotificationDto $notificationDto, string $template);
    public function sendToUserIds(array $user_id_list, NotificationDto $notificationDto, string $template);
    public function sendTo(array $to, NotificationDto $notificationDto, string $template);
}
