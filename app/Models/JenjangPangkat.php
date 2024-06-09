<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class JenjangPangkat extends Model
{
    use HasFactory;
    protected $table = 'tbl_jenjang_pangkat';
    public $timestamps = false;
    public function poinKoefisienPerformances(): HasMany
    {
        return $this->hasMany(PoinKoefisienPerformance::class, 'jenjang_id');
    }

}
