<?php

namespace Eyegil\WorkflowBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class PendingTaskDto extends BaseDto
{
    public $id;
    public $object_id;
    public $object_name;
    public $object_group;
    public $comment;
    public $task_type;
    public $task_action;
    public $task_status;
    public $workflow_name;
    public $workflow_template;
    public $flow_name;
    public $flow_id;
    public $remark;
    public $instance_id;
    public $workflow_id;
    public $object_task_id;
    public $object_task;
    public $pending_task_history;
}
