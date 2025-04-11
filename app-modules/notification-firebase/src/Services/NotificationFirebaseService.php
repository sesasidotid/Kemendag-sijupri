<?php

namespace Eyegil\NotificationFirebase\Services;

use Carbon\Carbon;
use Eyegil\NotificationFirebase\Services\FirebaseCMEngineService;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\NotificationBase\Dtos\NotificationMessageDto;
use Eyegil\NotificationBase\Services\INotificationService;
use Eyegil\NotificationBase\Services\NotificationDriverServiceMap;
use Eyegil\NotificationBase\Services\NotificationSubscriptionService;
use Eyegil\NotificationBase\Services\NotificationTopicService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Throwable;

class NotificationFirebaseService implements INotificationService
{
    const engine = "firebase";
    private $driver;

    public function __construct(
        private FirebaseMessageTokenService $firebaseMessageTokenService,
        private FirebaseCMEngineService $firebaseCMEngineService,
        private NotificationSubscriptionService $notificationSubscriptionService,
        private NotificationTopicService $notificationTopicService,
        private NotificationDriverServiceMap $notificationDriverServiceMap,
    ) {
        $this->driver = config("eyegil.notification.driver");
    }

    public function resubscribe($user_id)
    {
        $tokenList = $this->firebaseMessageTokenService->getTokenListByDeviceUserId($user_id);
        $notificationSubscriptionList = $this->notificationSubscriptionService->findByUserIdAndEngine($user_id, $this::engine);
        foreach ($notificationSubscriptionList as $key => $notificationSubscription) {
            $this->firebaseCMEngineService->subscribeToTopic($notificationSubscription->notification_topic_code, $tokenList);
        }
    }

    public function subscribe($topic_code, $user_id)
    {
        DB::transaction(function () use ($topic_code, $user_id) {
            $tokenList = $this->firebaseMessageTokenService->getTokenListByDeviceUserId($user_id);
            $this->notificationSubscriptionService->save($topic_code, $user_id, $this::engine);

            $this->firebaseCMEngineService->subscribeToTopic($topic_code, $tokenList);
        }, 3);
    }

    public function unsubscribe($topic_code, $user_id)
    {
        DB::transaction(function () use ($topic_code, $user_id) {
            $tokenList = $this->firebaseMessageTokenService->getTokenListByDeviceUserId($user_id);
            $this->notificationSubscriptionService->delete($topic_code, $user_id, $this::engine);

            $this->firebaseCMEngineService->unsubscribeFromTopic($topic_code, $tokenList);
        }, 3);
    }

    public function sendToTopic($notification_topic_code, NotificationDto $notificationDto, string $template)
    {
        $this->notificationTopicService->findById($notification_topic_code);

        $notificationMessage = null;
        if ($this->driver && is_string($this->driver)) {
            $notificationMessageDto = new NotificationMessageDto();
            $notificationMessageDto->title = $notificationDto->subject;
            $notificationMessageDto->body = $template;
            $notificationMessageDto->data = $notificationDto->additionalData;
            $notificationMessageDto->priority = optional($notificationDto)->options->priority ?? 0;
            $notificationMessageDto->read = false;
            $notificationMessageDto->expiry_date = optional($notificationDto)->options->expiry_date ?? Carbon::now()->addDays(7);
            $notificationMessageDto->notification_topic_code = $notification_topic_code;
            $notificationMessage = $this->notificationDriverServiceMap->get($this->driver)->save($notificationMessageDto);
        }

        $notificationDto->additionalData['id'] = optional($notificationMessage)->id ?? Str::uuid();
        try {
            $this->firebaseCMEngineService->sendNotificationToTopic(
                $notification_topic_code,
                $notificationDto->subject,
                preg_replace('/[^\S ]/', '.', $template),
                $notificationDto->additionalData ?? []
            );
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
        }
    }

    public function sendToUserIds(array $user_id_list, NotificationDto $notificationDto, string $template)
    {
        foreach ($user_id_list as $key => $user_id) {
            $tokenList = $this->firebaseMessageTokenService->getTokenListByDeviceUserId($user_id);

            $notificationMessage = null;
            if ($this->driver && is_string($this->driver)) {
                $notificationMessageDto = new NotificationMessageDto();
                $notificationMessageDto->title = $notificationDto->subject;
                $notificationMessageDto->body = $template;
                $notificationMessageDto->data = (object) $notificationDto->additionalData;
                $notificationMessageDto->priority = optional($notificationDto)->options->priority ?? 0;
                $notificationMessageDto->read = false;
                $notificationMessageDto->expiry_date = optional($notificationDto)->options->expiry_date ?? Carbon::now()->addDays(7);
                $notificationMessageDto->user_id = $user_id;
                $notificationMessage = $this->notificationDriverServiceMap->get($this->driver)->save($notificationMessageDto);
            }

            $notificationDto->additionalData['id'] = optional($notificationMessage)->id ?? Str::uuid();
            $this->sendTo($tokenList, $notificationDto, $template);
        }
    }

    public function sendTo(array $token_list, NotificationDto $notificationDto, string $template)
    {
        foreach ($token_list as $key => $token) {
            try {
                $this->firebaseCMEngineService->sendNotificationToToken(
                    $token,
                    $notificationDto->subject,
                    preg_replace('/[^\S ]/', '.', $template),
                    $notificationDto->additionalData ?? []
                );
            } catch (Throwable $e) {
                if ($e instanceof NotFound) {
                    $this->firebaseMessageTokenService->deleteByToken($token);
                } else {
                    Log::error($e->getMessage(), ['exception' => $e]);
                }
            }
        }
    }
}
