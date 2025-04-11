<?php

namespace Eyegil\SecurityBase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\SecurityBase\Dtos\RoleDto;
use Eyegil\SecurityBase\Services\RoleTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Illuminate\Http\Request;

#[Controller("/api/v1/role/task")]
class RoleTaskController
{

    public function __construct(
        private RoleTaskService $roleTaskService
    ) {}

    #[Post()]
    public function save(Request $request)
    {
        $roleDto = RoleDto::fromRequest($request)->validateSave();
        return $this->roleTaskService->create($roleDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $roleDto = RoleDto::fromRequest($request)->validateUpdate();
        return $this->roleTaskService->update($roleDto);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->roleTaskService->delete($request->id);
    }

    #[Post("/submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request);
        return $this->roleTaskService->submit($taskDto);
    }
}
