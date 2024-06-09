<?php

namespace App\Models\Audit;

use App\Http\Controllers\SearchService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AuditAktivitas extends Model
{
    use HasFactory, Notifiable, SearchService;

    protected $table = 'tbl_audit_aktivitas';
    public $timestamps = false;
    protected $fillable = [
        'nip',
        'name',
        'method',
        'ip_address',
        'user_agent',
        'tgl_access',
    ];
}
