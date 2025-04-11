<?php

namespace Eyegil\NotificationFirebase\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Factory;

class FirebaseCMEngineService
{
    protected $fcmEngine;

    public function __construct()
    {
        $this->fcmEngine = (new Factory)
            ->withServiceAccount(config('eyegil.firebase.credentials'))
            ->createMessaging();
    }

    public function sendNotificationToToken($token, $title, $body, array $data = [])
    {
        $notification = Notification::create($title, $body);
        $message = CloudMessage::new()
            ->toToken($token)
            ->withNotification($notification)
            ->withData($data);

        return $this->fcmEngine->send($message);
    }

    public function sendNotificationToTopic($topic, $title, $body, array $data = [])
    {
        $notification = Notification::create($title, $body);
        $message = CloudMessage::new()
            ->toTopic($topic)
            ->withNotification($notification)
            ->withData($data);

        return $this->fcmEngine->send($message);
    }

    public function subscribeToTopic(string $topic, array $tokens)
    {
        try {
            $this->fcmEngine->subscribeToTopic($topic, $tokens);
            return ['status' => 'success', 'message' => 'Tokens subscribed successfully'];
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function unsubscribeFromTopic(string $topic, array $tokens)
    {
        try {
            $this->fcmEngine->unsubscribeFromTopic($topic, $tokens);
            return ['status' => 'success', 'message' => 'Tokens unsubscribed successfully'];
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
