<?php

namespace Eyegil\WorkflowBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Serializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObjectKey extends Serializable
{
    use HasFactory;
    protected $table = 'wf_object_key';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "nullable" => false])]
    private $object_key;
    #[Column(["type" => "string", "nullable" => false])]
    private $object_value;
    #[Column(["type" => "string", "foreign" => PendingTask::class, "cascade" => ["DELETE"]])]
    private $pending_task_id;

    protected $fillable = ['id', 'object_key', 'object_value', 'pending_task_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
