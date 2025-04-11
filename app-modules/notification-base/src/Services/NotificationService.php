<?php

namespace Eyegil\NotificationBase\Services;

use Eyegil\NotificationBase\Dtos\NotificationDto;

class NotificationService
{
    public function __construct(
        private NotificationTemplateService $notificationTemplateService,
        private NotificationServiceMap $notificationServiceMap,
    ) {}

    public function sendTo(string $engine, array $to_list, string $notificationTemplateCode, NotificationDto $notificationDto)
    {
        $template = $this->notificationTemplateService->convertTemplate($notificationTemplateCode, $notificationDto->objectMap);
        $this->notificationServiceMap->get($engine)->sendTo($to_list, $notificationDto, $template);
    }

    public function sendToUserIds(string $engine, array $user_id_list, string $notificationTemplateCode, NotificationDto $notificationDto)
    {
        $template = $this->notificationTemplateService->convertTemplate($notificationTemplateCode, $notificationDto->objectMap);
        $this->notificationServiceMap->get($engine)->sendToUserIds($user_id_list, $notificationDto, $template);
    }

    public function sendToTopic(string $engine, $notification_topic_code, string $notificationTemplateCode, NotificationDto $notificationDto)
    {
        $template = $this->notificationTemplateService->convertTemplate($notificationTemplateCode, $notificationDto->objectMap);
        $this->notificationServiceMap->get($engine)->sendToTopic($notification_topic_code, $notificationDto, $template);
    }

    public function sendToCustom(string $engine, array $to_list, string $template, NotificationDto $notificationDto)
    {
        $this->notificationServiceMap->get($engine)->sendTo($to_list, $notificationDto, $template);
    }

    public function sendToUserIdsCustom(string $engine, array $user_id_list, string $template, NotificationDto $notificationDto)
    {
        $this->notificationServiceMap->get($engine)->sendToUserIds($user_id_list, $notificationDto, $template);
    }

    public function sendToTopicCustom(string $engine, $notification_topic_code, string $template, NotificationDto $notificationDto)
    {
        $this->notificationServiceMap->get($engine)->sendToTopic($notification_topic_code, $notificationDto, $template);
    }
}
