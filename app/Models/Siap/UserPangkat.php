<?php

namespace App\Models\Siap;

use App\Models\Maintenance\Pangkat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserPangkat extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_user_pangkat';

    protected $fillable = [
        'tmt',
        'sk_pangkat',
        'nip',
        'pangkat_id',
    ];

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class);
    }
}
