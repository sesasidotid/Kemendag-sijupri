<?php

namespace Eyegil\SecurityBase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\SecurityBase\Dtos\AuthenticationDto;
use Eyegil\SecurityBase\Dtos\UserDto;
use Eyegil\SecurityBase\Services\UserTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Illuminate\Http\Request;

#[Controller("/api/v1/user/task")]
class UserTaskController
{
    public function __construct(
        private UserTaskService $userTaskService
    ) {}

    #[Post()]
    public function save(Request $request)
    {
        $authenticationDto = UserDto::fromRequest($request)->validateSave();
        return $this->userTaskService->create($authenticationDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $userDto = UserDto::fromRequest($request)->validateUpdate();
        return $this->userTaskService->update($userDto);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->userTaskService->delete($request->id);
    }

    #[Post("/submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request)->validateRequest($request);
        return $this->userTaskService->submit($taskDto);
    }
}
