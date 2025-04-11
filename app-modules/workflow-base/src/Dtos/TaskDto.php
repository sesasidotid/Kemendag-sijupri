<?php

namespace Eyegil\WorkflowBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class TaskDto extends BaseDto
{
    public $id;
    public $task_action;
    public $object;
    public $remark;

    public function validateRequest(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'task_action' => 'required|string',
        ]);
        return $this;
    }
}
