<?php

namespace Eyegil\NotificationDriverDb\Services;

use Carbon\Carbon;
use Eyegil\NotificationBase\Dtos\NotificationMessageDto;
use Eyegil\NotificationBase\Services\INotificationDriverService;
use Eyegil\NotificationDriverDb\Models\NotificationMessage;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Support\Facades\DB;

class NotificationMessageService implements INotificationDriverService
{

    public function findById($id): NotificationMessage
    {
        $userContext = user_context();
        $notificationMessage = NotificationMessage::findOrThrowNotFound($id);
        if ($notificationMessage->user_id == optional($userContext)->id) {
            $notificationMessage->read = true;
            $notificationMessage->save();
        }

        return $notificationMessage;
    }

    public function getAllNotificationMessageByUserId($user_id)
    {
        return NotificationMessage::orWhereHas('notificationTopic', function ($query) use ($user_id) {
            $query->orWhereHas('notificationSubscription', function ($query_2) use ($user_id) {
                $query_2->where('user_id', $user_id);
            });
        })->orWhere('user_id', $user_id)
            ->orderBy('date_created', "ASC")
            ->orderBy('read')
            ->orderByDesc('priority')
            ->get();
    }

    public function findAllByUserId($user_id)
    {
        return NotificationMessage::where('user_id', $user_id)
            ->orderBy('date_created', "ASC")
            ->orderBy('read')
            ->orderByDesc('priority')
            ->get();
    }

    public function findAllByNotificationTopicNotificationSubscriptionUserId($user_id)
    {
        return NotificationMessage::whereHas('notificationTopic', function ($query) use ($user_id) {
            $query->whereHas('notificationSubscription', function ($query_2) use ($user_id) {
                $query_2->where('user_id', $user_id);
            });
        })->orderBy('date_created', "ASC")
            ->orderBy('read')
            ->orderByDesc('priority')
            ->get();
    }

    public function save(NotificationMessageDto $notificationMessageDto)
    {
        return DB::transaction(function () use ($notificationMessageDto) {
            $notificationMessage = new NotificationMessage();
            $notificationMessage->fromArray($notificationMessageDto->toArray());
            $notificationMessage['data'] = json_encode($notificationMessageDto->data);
            $notificationMessage->saveWithUUid();

            return $notificationMessage;
        });
    }

    public function deleteByUserId($user_id, $id)
    {
        return DB::transaction(function () use ($user_id, $id) {
            $notificationMessage = $this->findById($id);
            if ($notificationMessage->user_id != $user_id) {
                throw new RecordNotFoundException();
            }
            $notificationMessage->delete();

            return $notificationMessage;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $notificationMessage = $this->findById($id);
            $notificationMessage->delete();
            return $notificationMessage;
        });
    }

    public function deleteBatch(array $id_list)
    {
        return DB::transaction(function () use ($id_list) {
            NotificationMessage::whereIn('id', $id_list)
                ->delete();
        });
    }

    public function deleteBatchByUserId($user_id, array $id_list)
    {
        return DB::transaction(function () use ($user_id, $id_list) {
            NotificationMessage::whereIn('id', $id_list)
                ->where('user_id', $user_id)
                ->delete();
        });
    }

    public function deleteExpired()
    {
        return DB::transaction(function () {
            $deletedForUsers = NotificationMessage::whereNotNull('user_id')
                ->where('read', true)
                ->where('expire_date', '<', Carbon::now())
                ->delete();

            $deletedForTopics = NotificationMessage::whereNotNull('notification_topic_code')
                ->where('expire_date', '<', Carbon::now())
                ->delete();

            return ["deletedForUsers" => $deletedForUsers, "deletedForTopics" => $deletedForTopics];
        });
    }
}
