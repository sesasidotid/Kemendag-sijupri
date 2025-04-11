<?php

namespace Eyegil\SijupriAkp\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\SijupriAkp\Dtos\AkpDto;
use Eyegil\SijupriAkp\Services\AkpTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

#[Controller("/api/v1/akp/task")]
class AkpTaskController
{
    public function __construct(
        private AkpTaskService $akpTaskService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $pendingTaskSearch = $this->akpTaskService->findSearch(new Pageable($request->query()));
        return $pendingTaskSearch->setCollection($pendingTaskSearch->getCollection()->map(function ($pendingTask) {
            $result = $pendingTask->toArray();
            $result["akp_id"] = $pendingTask->objectTask->object->id;
            return $result;
        }));
    }

    #[Get("/failed/search")]
    public function findFailedSearch(Request $request)
    {
        $pendingTaskSearch = $this->akpTaskService->findFailedSearch(new Pageable($request->query()));
        return $pendingTaskSearch->setCollection($pendingTaskSearch->getCollection()->map(function ($pendingTask) {
            $result = $pendingTask->toArray();
            $result["akp_id"] = $pendingTask->objectTask->object->id;
            return $result;
        }));
    }

    #[Get("/{id}")]
    public function getDetailTask($id)
    {
        return $this->akpTaskService->getDetailTask($id);
    }

    #[Get("/nip/{nip}")]
    public function findByNip($nip)
    {
        return $this->akpTaskService->findByNip($nip);
    }

    #[Post()]
    public function create(Request $request)
    {
        $akpDto = AkpDto::fromRequest($request);
        return $this->akpTaskService->create($akpDto->nip);
    }

    #[Post("submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request)->validateRequest($request);
        return $this->akpTaskService->submit($taskDto);
    }
}
