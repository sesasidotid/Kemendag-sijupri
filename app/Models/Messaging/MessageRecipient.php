<?php

namespace App\Models\Messaging;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MessageRecipient extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_message_recipient';
    protected $fillable = [
        'read_at',
        'message_id',
        'recipient_id'
    ];
}
