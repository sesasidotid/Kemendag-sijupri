<?php

namespace Eyegil\WorkflowBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Serializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignee extends Serializable
{
    use HasFactory;
    protected $table = 'wf_assignee';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "nullable" => false])]
    private $assignee_type;

    #[Column(["type" => "string", "nullable" => false])]
    private $assignee;
    #[Column(["type" => "string", "foreign" => PendingTask::class])]
    private $pending_task_id;

    protected $fillable = ['id', 'assignee_type', 'assignee', 'pending_task_id'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
