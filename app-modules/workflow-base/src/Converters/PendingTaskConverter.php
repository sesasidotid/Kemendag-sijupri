<?php

namespace Eyegil\WorkflowBase\Converters;

use Eyegil\WorkflowBase\Dtos\PendingTaskDto;
use Eyegil\WorkflowBase\Models\PendingTask;

class PendingTaskConverter
{
    public static function toDto(PendingTask $pendingTask): PendingTaskDto
    {
        $pendingTaskDto = new PendingTaskDto();
        return $pendingTaskDto->fromArray($pendingTask->toArray());
    }

    public static function withObjectTask(PendingTask $pendingTask): PendingTaskDto
    {
        $pendingTaskDto = static::toDto($pendingTask);
        $pendingTaskDto->object_task = $pendingTask->objectTask;
        return $pendingTaskDto;
    }

    public static function withPendingTaskHistory(PendingTask $pendingTask): PendingTaskDto
    {
        $pendingTaskDto = static::toDto($pendingTask);
        $pendingTaskDto->pending_task_history = $pendingTask->pendingTaskHistory;
        return $pendingTaskDto;
    }

    public static function withObjectTaskAndPendingTaskHistory(PendingTask $pendingTask): PendingTaskDto
    {
        $pendingTaskDto = static::withObjectTask($pendingTask);
        $pendingTaskDto->pending_task_history = $pendingTask->pendingTaskHistory;
        return $pendingTaskDto;
    }
}
