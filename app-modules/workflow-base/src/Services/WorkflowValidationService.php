<?php

namespace Eyegil\WorkflowBase\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\WorkflowBase\Enums\TaskStatus;

class WorkflowValidationService
{
    public function __construct(
        private PendingTaskService $pendingTaskService
    ) {}

    public function validateTaskStart($workflowName, $objectId, $objectKeys, $taskAction)
    {
        $pendingTaksList = $this->pendingTaskService->findByObjectKeysAndWorkflowNameAndStatusPending($objectKeys, $workflowName);
        foreach ($pendingTaksList as $key => $pendingTask) {
            if (!in_array($pendingTask->task_status, [TaskStatus::COMPLETED->name, TaskStatus::FAILED->name])) {
                throw new BusinessException("Task Already Exist", "WFL-00004");
            }
        }

        if ($taskAction === "create") {
            if ($objectId) {
                $pendingTask = $this->pendingTaskService->findByWorkflowNameAndObjectIdAndTaskStatus($workflowName, $objectId, TaskStatus::PENDING->name);
                if ($pendingTask) throw new BusinessException("WFL00002", "task already exist");
            }
        } else if ($taskAction === "update") {
            if ($objectId) {
                $pendingTask = $this->pendingTaskService->findByWorkflowNameAndObjectIdAndTaskStatus($workflowName, $objectId, TaskStatus::PENDING->name);
                if ($pendingTask) throw new BusinessException("WFL00002", "task already exist");
            }
        } else if ($taskAction === "delete") {
            if ($objectId) {
                $pendingTask = $this->pendingTaskService->findByWorkflowNameAndObjectIdAndTaskStatus($workflowName, $objectId, TaskStatus::PENDING->name);
                if ($pendingTask) throw new BusinessException("WFL00002", "task already exist");
            }
        }
    }

    public function validateTaskSubmit($pendingTask)
    {
        if (!$pendingTask) throw new BusinessException("WFL00001", "task not found");
        if ($pendingTask->taskStatus == TaskStatus::COMPLETED->name) throw new BusinessException("task already completed", "WFL-00003");
    }
}
