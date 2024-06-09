<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AuditTimeline extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_audit_timeline';
    protected $fillable = [
        'created_at',
        'association',
        'association_key',
        'object',
        'description',
        'status',
    ];
}
