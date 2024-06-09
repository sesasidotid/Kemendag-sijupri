<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PangkatGolongan extends Model
{

    use HasFactory;

    protected $table = 'tbl_pangkat_golongan';
    public $timestamps = false;
    public function poinKoefisienPerformances(): HasMany
    {
        return $this->hasMany(PoinKoefisienPerformance::class, 'pangkat_id');
    }
}
