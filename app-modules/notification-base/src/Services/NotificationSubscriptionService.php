<?php

namespace Eyegil\NotificationBase\Services;

use Eyegil\NotificationBase\Models\NotificationSubscription;
use Illuminate\Support\Facades\DB;

class NotificationSubscriptionService
{
    public function findByNotificationTopicIdAndUserIdAndEngine($notification_topic_code, $user_id, $engine): NotificationSubscription
    {
        return NotificationSubscription::where('notification_topic_code', $notification_topic_code)
            ->where('user_id', $user_id)
            ->where('engine', $engine)
            ->first();
    }

    public function findByNotificationTopicIdAndEngine($notification_topic_code, $engine)
    {
        return NotificationSubscription::where('notification_topic_code', $notification_topic_code)
            ->where('engine', $engine)
            ->get();
    }

    public function findByUserIdAndEngine($user_id, $engine)
    {
        return NotificationSubscription::where('user_id', $user_id)
            ->where('engine', $engine)
            ->get();
    }

    public function save($notification_topic_code, $user_id, $engine)
    {
        $notificationSubscription = $this->findByNotificationTopicIdAndUserIdAndEngine($notification_topic_code, $user_id, $engine);
        if ($notificationSubscription) {
            return $notificationSubscription;
        }

        return DB::transaction(function () use ($notification_topic_code, $user_id) {
            $notificationSubscription = new NotificationSubscription();
            $notificationSubscription->user_id = $user_id;
            $notificationSubscription->notification_topic_code = $notification_topic_code;
            $notificationSubscription->saveWithUUid();

            return $notificationSubscription;
        });
    }

    public function delete($notification_topic_code, $user_id, $engine)
    {
        return DB::transaction(function () use ($notification_topic_code, $user_id, $engine) {
            NotificationSubscription::where('notification_topic_code', $notification_topic_code)
                ->where('user_id', $user_id)
                ->where('engine', $engine)
                ->delete();
        });
    }
}
