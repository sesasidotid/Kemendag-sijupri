<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\RiwayatPendidikanDto;
use Eyegil\SijupriSiap\Services\RiwayatPendidikanTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\PendingTaskService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_pendidikan/task")]
class RiwayatPendidikanTaskController
{
    public function __construct(
        private RiwayatPendidikanTaskService $riwayatPendidikanTaskService,
        private PendingTaskService $pendingTaskService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $userContext = user_context();

        $pageable = new Pageable($request->query);
        $pageable->addEqual("object_group", $userContext->id);
        $pageable->addEqual("workflow_name", 'rw_pendidikan_task');
        $pageable->addEqual("task_status", TaskStatus::PENDING->name);
        return $this->pendingTaskService->findSearch($pageable);
    }

    #[Post()]
    public function create(Request $request)
    {
        $riwayatPendidikanDto = RiwayatPendidikanDto::fromRequest($request)->validateSave();
        $this->riwayatPendidikanTaskService->create($riwayatPendidikanDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $riwayatPendidikanDto = RiwayatPendidikanDto::fromRequest($request);
        $this->riwayatPendidikanTaskService->update($riwayatPendidikanDto);
    }

    #[Post("/submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request);
        $this->riwayatPendidikanTaskService->submit($taskDto);
    }
}
