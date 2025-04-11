<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\RiwayatKinerjaDto;
use Eyegil\SijupriSiap\Services\RiwayatKinerjaTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\PendingTaskService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_kinerja/task")]
class RiwayatKinerjaTaskController
{
    public function __construct(
        private RiwayatKinerjaTaskService $riwayatKinerjaTaskService,
        private PendingTaskService $pendingTaskService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $userContext = user_context();

        $pageable = new Pageable($request->query);
        $pageable->addEqual("object_group", $userContext->id);
        $pageable->addEqual("workflow_name", 'rw_kinerja_task');
        $pageable->addEqual("task_status", TaskStatus::PENDING->name);
        return $this->pendingTaskService->findSearch($pageable);
    }

    #[Get("/{id}")]
    public function detail() {}

    #[Post("")]
    public function create(Request $request)
    {
        $riwayatKinerjaDto = RiwayatKinerjaDto::fromRequest($request)->validateSave();
        $this->riwayatKinerjaTaskService->create($riwayatKinerjaDto);
    }

    #[Put("")]
    public function update(Request $request)
    {
        $riwayatKinerjaDto = RiwayatKinerjaDto::fromRequest($request);
        $this->riwayatKinerjaTaskService->update($riwayatKinerjaDto);
    }

    #[Post("/submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request);
        $this->riwayatKinerjaTaskService->submit($taskDto);
    }
}
