<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Metadata;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Counter extends Updatable
{
    use HasFactory;

    protected $table = 'mnt_counter';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $code;
    #[Column(["type" => "integer"])]
    private $num;

    protected $fillable = ['code', 'num'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
