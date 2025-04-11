<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\RiwayatPangkatDto;
use Eyegil\SijupriSiap\Services\RiwayatPangkatTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\PendingTaskService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_pangkat/task")]
class RiwayatPangkatTaskController
{
    public function __construct(
        private RiwayatPangkatTaskService $riwayatPangkatTaskService,
        private PendingTaskService $pendingTaskService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $userContext = user_context();

        $pageable = new Pageable($request->query);
        $pageable->addEqual("object_group", $userContext->id);
        $pageable->addEqual("workflow_name", 'rw_pangkat_task');
        $pageable->addEqual("task_status", TaskStatus::PENDING->name);
        return $this->pendingTaskService->findSearch($pageable);
    }

    #[Get("/{id}")]
    public function detail() {}

    #[Post("")]
    public function create(Request $request)
    {
        $riwayatPangkatDto = RiwayatPangkatDto::fromRequest($request)->validateSave();
        $this->riwayatPangkatTaskService->create($riwayatPangkatDto);
    }

    #[Put("")]
    public function update(Request $request)
    {
        $riwayatPangkatDto = RiwayatPangkatDto::fromRequest($request);
        $this->riwayatPangkatTaskService->update($riwayatPangkatDto);
    }

    #[Post("/submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request);
        $this->riwayatPangkatTaskService->submit($taskDto);
    }
}
