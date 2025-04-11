<?php

namespace Eyegil\NotificationDriverDb\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\NotificationDriverDb\Services\NotificationMessageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/notification_message")]
class NotificationMessageController
{
    public function __construct(
        private NotificationMessageService $notificationMessageService
    ) {}

    #[Get("/personal")]
    public function findAllByUserId()
    {
        $userContext = user_context();
        return $this->notificationMessageService->findAllByUserId($userContext->id);
    }

    #[Get("/group")]
    public function findAllByNotificationTopicNotificationSubscriptionUserId()
    {
        $userContext = user_context();
        return $this->notificationMessageService->findAllByNotificationTopicNotificationSubscriptionUserId($userContext->id);
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->notificationMessageService->findById($id);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        $userContext = user_context();
        return $this->notificationMessageService->deleteByUserId($userContext->id, $id);
    }

    #[Post("/delete")]
    public function deleteBatchByUserId(Request $request)
    {
        $userContext = user_context();
        return $this->notificationMessageService->deleteBatchByUserId($userContext->id, $request->id_list);
    }
}
