<?php

namespace Eyegil\WorkflowBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingTask extends Updatable
{
    use HasFactory;
    protected $table = 'wf_pending_task';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "nullable" => true, "index" => true])]
    private $object_id;

    #[Column(["type" => "string", "nullable" => true, "index" => true])]
    private $object_name;

    #[Column(["type" => "string", "nullable" => true, "index" => true])]
    private $object_group;

    #[Column(["type" => "string", "nullable" => true])]
    private $comment;

    #[Column(["type" => "string", "nullable" => true])]
    private $task_type;

    #[Column(["type" => "string", "nullable" => true])]
    private $task_action;

    #[Column(["type" => "string", "default" => "PENDING"])]
    private $task_status;

    #[Column(["type" => "string"])]
    private $workflow_name;

    #[Column(["type" => "string", "nullable" => true])]
    private $workflow_template;

    #[Column(["type" => "text", "nullable" => true])]
    private $flow_name;

    #[Column(["type" => "text", "nullable" => true])]
    private $flow_id;

    #[Column(["type" => "text", "nullable" => true])]
    private $remark;

    #[Column(["type" => "string", "nullable" => true])]
    private $instance_id;

    #[Column(["type" => "string", "nullable" => true])]
    private $workflow_id;
    #[Column(["type" => "string", "foreign" => ObjectTask::class])]
    private $object_task_id;

    protected $fillable = ['id', 'object', 'prev_object', 'flow_id', 'object_old', 'object_id', 'object_name', 'object_group', 'comment', 'task_type', 'task_action', 'task_status', 'workflow_name', 'workflow_template', 'flow_name', 'instance_id', 'workflow_id', 'object_task_id', 'remark'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function pendingTaskHistory()
    {
        return $this->hasMany(PendingTask::class, "instance_id", "instance_id");
    }

    public function objectKeyList()
    {
        return $this->hasMany(ObjectKey::class, "pending_task_id", "id");
    }

    public function objectTask()
    {
        return $this->belongsTo(ObjectTask::class, "object_task_id", "id");
    }

    public function assignee()
    {
        return $this->hasMany(Assignee::class, "pending_task_id", "id");
    }
}
