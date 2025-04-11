<?php

namespace Eyegil\NotificationBase\Services;

use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\NotificationBase\Dtos\NotificationMessageDto;

interface INotificationDriverService
{
    public function findById($id);
    public function getAllNotificationMessageByUserId($user_id);
    public function findAllByUserId($user_id);
    public function findAllByNotificationTopicNotificationSubscriptionUserId($user_id);
    public function save(NotificationMessageDto $notificationMessageDto);
    public function deleteByUserId($user_id, $id);
    public function delete($id);
    public function deleteBatch(array $id_list);
}
