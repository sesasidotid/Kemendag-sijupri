<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendidikanPangkat extends Updatable
{
    use HasFactory;

    protected $table = 'mnt_pendidikan_pangkat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => Pendidikan::class])]
    private $pendidikan_code;
    #[Column(["type" => "string", "foreign" => Pangkat::class])]
    private $pangkat_code;

    protected $fillable = ['id', 'pendidikan_code', 'pangkat_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function pendidikan()
    {
        $this->belongsTo(Pangkat::class, 'pendidikan_code', 'code');
    }

    public function pangkat()
    {
        $this->belongsTo(Pangkat::class, 'pangkat_code', 'code');
    }
}
