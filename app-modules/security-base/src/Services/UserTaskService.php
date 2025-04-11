<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\SecurityBase\Dtos\UserDto;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\WorkflowService;
use Illuminate\Support\Facades\DB;

class UserTaskService
{
    const workflow_name = "user_task";

    public function __construct(
        private WorkflowService $workflowService,
        private UserService $userService,
        private UserAuthenticationService $userAuthenticationService,
    ) {}

    public function create(UserDto $userDto)
    {
        return $this->workflowService->startCreateTask(
            $this::workflow_name,
            $userDto->id,
            $userDto->name,
            ['id' => $userDto->id],
            $userDto,
        );
    }

    public function update(UserDto $userDto)
    {
        $user = $this->userService->findById($userDto->id);
        $userDto_old = new UserDto();
        $userDto_old->fromArray($user->toArray());

        return $this->workflowService->startUpdateTask(
            $this::workflow_name,
            $userDto->id,
            $userDto->name,
            ['id' => $userDto->id],
            $userDto,
            $userDto_old
        );
    }

    public function delete(string $id)
    {
        $user = $this->userService->findById($id);
        $userDto = new UserDto();
        $userDto->fromArray($user->toArray());

        return $this->workflowService->startDeleteTask(
            $this::workflow_name,
            $user->id,
            $user->name,
            ['id' => $userDto->id],
            $userDto,
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
                $userDto = new UserDto();
                $userDto->fromArray((array) $task->objectTask->object);

                if (strtolower($task->task_action) == strtolower(TaskStatus::APPROVE->name)) {
                    if ($task->task_type == "create") {
                        return $this->userAuthenticationService->register($userDto);
                    } else if ($task->task_type == "update") {
                        return $this->userAuthenticationService->update($userDto);
                    } else if ($task->task_type == "delete") {
                        return $this->userAuthenticationService->delete($task->objectId);
                    }
                }
            } else {
                return $task;
            }
        });
    }
}
