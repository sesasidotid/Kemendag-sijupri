<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\SecurityBase\Dtos\AuthenticationDto;
use Eyegil\SecurityBase\Dtos\RoleDto;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;

class RoleTaskService
{
    const workflow_name = "role_task";

    public function __construct(
        private WorkflowService $workflowService,
        private RoleService $roleService,
    ) {}

    public function create(RoleDto $roleDto)
    {
        return $this->workflowService->startCreateTask(
            $this::workflow_name,
            $roleDto->code,
            $roleDto->name,
            ['code' => $roleDto->code],
            $roleDto,
        );
    }

    public function update(RoleDto $roleDto)
    {
        $role = $this->roleService->findByCode($roleDto->code);
        $roleDto_old = new RoleDto();
        $roleDto_old->fromArray($role->toArray());

        return $this->workflowService->startUpdateTask(
            $this::workflow_name,
            $roleDto->code,
            $roleDto->name,
            ['code' => $roleDto->code],
            $roleDto,
            $roleDto_old
        );
    }

    public function delete(string $code)
    {
        $role = $this->roleService->findByCode($code);
        $roleDto = new RoleDto();
        $roleDto->fromArray($role->toArray());

        return $this->workflowService->startDeleteTask(
            $this::workflow_name,
            $role->code,
            $role->name,
            ['code' => $roleDto->code],
            $roleDto,
        );
    }

    public function submit(TaskDto $taskDto)
    {
        return DB::transaction(function () use ($taskDto) {
            $task = $this->workflowService->submitTask(
                $taskDto->id,
                $taskDto->task_action,
                $taskDto->object,
                $taskDto->remark
            );

            if ($task->task_status == TaskStatus::COMPLETED->name) {
                $roleDto = new RoleDto();
                $roleDto->fromArray((array) $task->objectTask->object);

                if (strtolower($task->taskAction) == strtolower(TaskStatus::APPROVE->name)) {
                    if ($task->task_type == "create") {
                        return $this->roleService->save($roleDto);
                    } else if ($task->task_type == "update") {
                        return $this->roleService->update($roleDto);
                    } else if ($task->task_type == "delete") {
                        return $this->roleService->delete($task->objectId);
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
