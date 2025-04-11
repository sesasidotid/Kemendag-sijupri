<?php

namespace Eyegil\WorkflowBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class TaskDetailDto extends BaseDto
{
    public $id;
    public $object;
    public $object_old;
    public $object_id;
    public $object_value;
    public $object_name;
    public $comment;
    public $task_type;
    public $task_action;
    public $task_status;
    public $workflow_name;
    public $workflow_template;
    public $remark;
    public $instance_id;
    public $workflow_id;
    public array $task_history_list = [];
}
