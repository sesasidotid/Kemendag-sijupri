<?php

namespace App\Models\Messaging;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Announcement extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_announcement';
    protected $fillable = [
        'title',
        'content',
        'sender_id',
        'group_code',
        'notification_id'
    ];
}
