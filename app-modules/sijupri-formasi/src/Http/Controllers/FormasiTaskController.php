<?php

namespace Eyegil\SijupriFormasi\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\SijupriFormasi\Dtos\FormasiDto;
use Eyegil\SijupriFormasi\Services\FormasiTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Illuminate\Http\Request;

#[Controller("/api/v1/formasi/task")]
class FormasiTaskController
{
    public function __construct(
        private FormasiTaskService $formasiTaskService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->formasiTaskService->findSearch(new Pageable($request->query()));
    }

    #[Get("/{pending_task_id}")]
    public function getDetailTask($pending_task_id)
    {
        return $this->formasiTaskService->getDetailTask($pending_task_id);
    }

    #[Get("/unit_kerja/{unit_kerja_id}")]
    public function findByUnitKerjaId($unit_kerja_id)
    {
        return $this->formasiTaskService->findByUnitKerjaId($unit_kerja_id);
    }

    #[Post()]
    public function save(Request $request)
    {
        $formasiRequestDto = FormasiDto::fromRequest($request);
        return $this->formasiTaskService->create($formasiRequestDto);
    }

    #[Post("/submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request);
        return $this->formasiTaskService->submit($taskDto);
    }
}
