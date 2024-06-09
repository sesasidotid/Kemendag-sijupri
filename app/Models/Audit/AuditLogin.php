<?php

namespace App\Models\Audit;

use App\Http\Controllers\SearchService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AuditLogin extends Model
{
    use HasFactory, Notifiable, SearchService;

    protected $table = 'tbl_audit_login';
    public $timestamps = false;
    protected $fillable = [
        'nip',
        'ip_address',
        'user_agent',
        'tgl_login',
    ];
}
