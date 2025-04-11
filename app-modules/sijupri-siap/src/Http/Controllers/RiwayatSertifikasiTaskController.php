<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\RiwayatSertifikasiDto;
use Eyegil\SijupriSiap\Services\RiwayatSertifikasiTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Services\PendingTaskService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_sertifikasi/task")]
class RiwayatSertifikasiTaskController
{
    public function __construct(
        private RiwayatSertifikasiTaskService $riwayatSertifikasiTaskService,
        private PendingTaskService $pendingTaskService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $userContext = user_context();

        $pageable = new Pageable($request->query);
        $pageable->addEqual("object_group", $userContext->id);
        $pageable->addEqual("workflow_name", 'rw_sertifikasi_task');
        $pageable->addEqual("task_status", TaskStatus::PENDING->name);
        return $this->pendingTaskService->findSearch($pageable);
    }

    #[Get("/{id}")]
    public function detail() {}

    #[Post("")]
    public function create(Request $request)
    {
        $riwayatSertifikasiDto = RiwayatSertifikasiDto::fromRequest($request)->validateSave();
        $this->riwayatSertifikasiTaskService->create($riwayatSertifikasiDto);
    }

    #[Put("")]
    public function update(Request $request)
    {
        $riwayatSertifikasiDto = RiwayatSertifikasiDto::fromRequest($request);
        $this->riwayatSertifikasiTaskService->update($riwayatSertifikasiDto);
    }

    #[Post("/submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request);
        $this->riwayatSertifikasiTaskService->submit($taskDto);
    }
}
