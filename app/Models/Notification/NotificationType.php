<?php

namespace App\Models\Notification;

use App\Http\Controllers\SearchService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NotificationType extends Model
{
    use HasFactory, Notifiable, SearchService;

    protected $table = 'tbl_notification_type';
}
