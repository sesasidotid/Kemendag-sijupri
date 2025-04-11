<?php

namespace Eyegil\SijupriMaintenance\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\WorkflowBase\Models\PendingTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodePendaftaran extends Updatable
{
    use HasFactory;

    protected $table = 'mnt_periode_pendaftaran';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string"])]
    private $type;

    #[Column(["type" => "date"])]
    private $start_date;

    #[Column(["type" => "date"])]
    private $end_date;

    protected $fillable = ['id', 'type', 'start_date', 'end_date'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
