<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Report extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_report';

    protected $fillable = [
        'filename',
        'file_type',
        'status',
        'type',
        'report_id',
        'user_id',
    ];
}
