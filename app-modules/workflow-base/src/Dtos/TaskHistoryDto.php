<?php

namespace Eyegil\WorkflowBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class TaskHistoryDto extends BaseDto
{
    public $id;
    public $object_id;
    public $object_value;
    public $object_name;
    public $task_type;
    public $task_action;
    public $task_status;
    public $remark;
    public $instance_id;
    public $workflow_id;
}
