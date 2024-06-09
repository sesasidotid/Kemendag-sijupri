<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatan extends Model
{
    use HasFactory;

    protected $table = 'tbl_riwayat_jabatan';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
