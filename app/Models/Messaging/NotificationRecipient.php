<?php

namespace App\Models\Messaging;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NotificationRecipient extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_notification_recipient';
    protected $fillable = [
        'read_at',
        'notification_id',
        'recipient_id',
    ];
}
