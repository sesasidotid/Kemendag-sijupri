<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SystemConfiguration extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'code';
    
    public $incrementing = false;

    protected $table = 'tbl_system_configuration';

    public $timestamps = false;

    protected $fillable = [];

    protected $casts = [
        'property' => 'json',
    ];
}
