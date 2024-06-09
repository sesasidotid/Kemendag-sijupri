<?php

namespace App\Http\Controllers\Service;

use App\Enums\NotificationType;
use App\Models\Messaging\Announcement;
use App\Models\Messaging\Notification;
use App\Models\Messaging\NotificationRecipient;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class MessagingService
{
    public function findNotificationAllByGroupCodeAndRecipientId(array $groupCodeList, $recipient_id)
    {
        $qry_announcement = DB::table('tbl_notification')
            ->rightJoin('tbl_announcement', 'tbl_notification.id', '=', 'tbl_announcement.notification_id')
            ->leftJoin('tbl_notification_recipient', function ($join) use ($recipient_id) {
                $join->on('tbl_notification.id', '=', 'tbl_notification_recipient.notification_id')
                    ->where('tbl_notification_recipient.recipient_id', '=', $recipient_id);
            })
            ->whereNull('tbl_notification_recipient.id')
            ->whereIn('tbl_announcement.group_code', $groupCodeList)
            ->select('tbl_notification.*', 'tbl_announcement.title', 'tbl_announcement.id as content_id');

        $qry_message = DB::table('tbl_notification')
            ->rightJoin('tbl_message', 'tbl_notification.id', '=', 'tbl_message.notification_id')
            ->leftJoin('tbl_notification_recipient', function ($join) use ($recipient_id) {
                $join->on('tbl_notification.id', '=', 'tbl_notification_recipient.notification_id')
                    ->where('tbl_notification_recipient.recipient_id', '=', $recipient_id);
            })
            ->whereNull('tbl_notification_recipient.id')
            ->select('tbl_notification.*', 'tbl_message.title', 'tbl_message.id as content_id');

        return $qry_message->union($qry_announcement)->get();
    }

    public function findAnnouncementById($id)
    {
        return Announcement::where('id', (int)$id)->first();
    }

    public function createAnnouncement($title, $content, $role_code)
    {
        return DB::transaction(function () use ($title, $content, $role_code) {
            $userContext = auth()->user();
            $notification = $this->createNotification(NotificationType::ANNOUNCEMENT, $userContext->nip);

            return Announcement::create([
                'title' => $title,
                'content' => $content,
                'sender_id' => $userContext->nip,
                'group_code' => $role_code,
                'notification_id' => $notification->id,
            ]);
        });
    }

    public function updateAnnouncement($id, $title, $content)
    {
        return DB::transaction(function () use ($id, $title, $content) {
            $announcement = Announcement::where('id', (int)$id)->first();
            $announcement->title = $title;
            $announcement->content = $content;
            $announcement->save();
        });
    }

    private function createNotification($type, $sender_id)
    {
        return DB::transaction(function () use ($type, $sender_id) {
            return Notification::create([
                'type' => $type,
                'sender_id' => $sender_id,
            ]);
        });
    }

    public function setAnnouncementRead(Announcement $announcement)
    {
        return DB::transaction(function () use ($announcement) {
            $userContext = auth()->user();
            NotificationRecipient::create([
                'read_at' => now(),
                'notification_id' => $announcement->notification_id,
                'recipient_id' => $userContext->nip,
            ]);
        });
    }
}
