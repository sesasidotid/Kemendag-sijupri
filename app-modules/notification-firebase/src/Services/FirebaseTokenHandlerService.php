<?php

namespace Eyegil\NotificationFirebase\Services;

use Eyegil\NotificationBase\Services\NotificationSubscriptionService;
use Eyegil\NotificationBase\Services\NotificationTopicService;
use Eyegil\NotificationFirebase\Dtos\FcmTokenDto;
use Illuminate\Support\Facades\DB;

class FirebaseTokenHandlerService
{

    public function __construct(
        private NotificationTopicService $notificationTopicService,
        private NotificationFirebaseService $notificationFirebaseService,
        private FirebaseMessageTokenService $firebaseMessageTokenService,
    ) {}

    public function createOrUpdate(FcmTokenDto $fcmTokenDto)
    {
        DB::transaction(function () use ($fcmTokenDto) {
            $firebaseMessageToken = $this->firebaseMessageTokenService->findByDeviceId($fcmTokenDto->device_id);
            if ($firebaseMessageToken) {
                $firebaseMessageToken = $this->firebaseMessageTokenService->update($fcmTokenDto);
                $device = $firebaseMessageToken->device;
                $this->notificationFirebaseService->resubscribe($device->user_id);
            } else {
                $userContext = user_context();
                $this->firebaseMessageTokenService->save($fcmTokenDto);

                $notificationTopicList = $this->notificationTopicService->findByRoleCodeList($userContext->role_codes);
                foreach ($notificationTopicList as $key => $notificationTopic) {
                    $this->notificationFirebaseService->subscribe($notificationTopic->code, $userContext->id);
                }
            }
        });
    }
}
