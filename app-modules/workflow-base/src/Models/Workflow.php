<?php

namespace Eyegil\WorkflowBase\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workflow extends Updatable
{
    use HasFactory;
    protected $table = 'ewf_workflow';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "nullable" => false])]
    private $instance_id;

    #[Column(["type" => "string", "nullable" => false])]
    private $task_id;

    #[Column(["type" => "string", "nullable" => false])]
    private $state;

    #[Column(["type" => "json", "nullable" => false])]
    private $context;

    #[Column(["type" => "enum", "default" => TaskStatus::PENDING->name, 'enum' => TaskStatus::class])]
    private $status;

    protected $fillable = ['id', 'instance_id', 'task_id', 'state', 'context', 'status'];
    protected $casts = ['context' => 'object'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
