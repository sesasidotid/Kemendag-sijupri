<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Storage extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_storage';

    protected $fillable = [
        'association',
        'association_key',
        'file',
        'task_status',
        'name',
    ];
}
