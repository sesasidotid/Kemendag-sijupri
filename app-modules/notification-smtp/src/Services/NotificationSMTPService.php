<?php

namespace Eyegil\NotificationSmtp\Services;

use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\NotificationBase\Services\INotificationService;
use Eyegil\NotificationBase\Services\NotificationSubscriptionService;
use Eyegil\NotificationBase\Services\NotificationTopicService;
use Eyegil\SecurityBase\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NotificationSMTPService implements INotificationService
{
    const engine = "smtp";

    public function __construct(
        private UserService $userService,
        private NotificationSubscriptionService $notificationSubscriptionService,
        private NotificationTopicService $notificationTopicService,
    ) {}

    public function subscribe($topic_code, $user_id)
    {
        DB::transaction(function () use ($topic_code, $user_id) {
            $this->notificationSubscriptionService->save($topic_code, $user_id, $this::engine);
        });
    }
    public function unsubscribe($topic_code, $user_id)
    {
        DB::transaction(function () use ($topic_code, $user_id) {
            $this->notificationSubscriptionService->delete($topic_code, $user_id, $this::engine);
        });
    }

    public function sendToTopic($notification_topic_code, NotificationDto $notificationDto, string $template)
    {
        $notificationSubscriptionList = $this->notificationSubscriptionService->findByNotificationTopicIdAndEngine($notification_topic_code, $this::engine);
        $email_list = [];
        foreach ($notificationSubscriptionList as $key => $notificationSubscription) {
            $user = $notificationSubscription->user;
            if ($user->email) $email_list[] = $user->email;
        }
        $this->sendTo($email_list, $notificationDto, $template);
    }

    public function sendToUserIds(array $user_id_list, NotificationDto $notificationDto, string $template)
    {
        $email_list = [];
        foreach ($user_id_list as $key => $user_id) {
            $user = $this->userService->findById($user_id);
            if ($user->email) $email_list[] = $user->email;
        }
        $this->sendTo($email_list, $notificationDto, $template);
    }

    public function sendTo(array $email_list, NotificationDto $notificationDto, string $template)
    {
        $mail = Mail::to($email_list);

        if (!empty($notificationDto->cc))
            $mail->cc($notificationDto->cc);
        if (!empty($notificationDto->bcc))
            $mail->bcc($notificationDto->bcc);
        $mail->send(new SMTPEngineService($template, $notificationDto));
    }
}
