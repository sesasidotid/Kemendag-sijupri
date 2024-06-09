<?php

namespace App\Models\Messaging;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Message extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_message';
    protected $fillable = [
        'title',
        'content',
        'sender_id',
        'notification_id',
    ];
}
