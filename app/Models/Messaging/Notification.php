<?php

namespace App\Models\Messaging;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_notification';
    protected $fillable = [
        'sender_id',
        'type'
    ];

    public function notificationRecipient()
    {
        return $this->hasOne(NotificationRecipient::class);
    }

    public function content()
    {
        if ($this->type === NotificationType::ANNOUNCEMENT) {
            return $this->hasOne(Announcement::class);
        } else {
            return $this->hasOne(Message::class);
        }
    }

    public function announcement()
    {
        return $this->hasOne(Announcement::class);
    }

    public function message()
    {
        return $this->hasOne(Message::class);
    }
}
