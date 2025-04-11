<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\JFDto;
use Eyegil\SijupriSiap\Services\JFTaskService;
use Eyegil\WorkflowBase\Dtos\TaskDto;
use Illuminate\Http\Request;

#[Controller("/api/v1/jf/task")]
class JFTaskController
{
    public function __construct(
        private JFTaskService $jfTaskService
    ) {}

    #[Get("/search")]
    public function findWithoutKinerjaSearch(Request $request)
    {
        return $this->jfTaskService->findWithoutKinerjaSearch(new Pageable($request->query));
    }

    #[Get("/kinerja/search")]
    public function findWithKinerjaSearch(Request $request)
    {
        return $this->jfTaskService->findWithKinerjaSearch(new Pageable($request->query));
    }

    #[Get("/group/{object_group}")]
    public function detail($object_group)
    {
        return $this->jfTaskService->detail($object_group);
    }

    #[Get("/kinerja/group/{object_group}")]
    public function kinerjaDetail($object_group)
    {
        return $this->jfTaskService->kinerjaDetail($object_group);
    }

    #[Put("")]
    public function update(Request $request)
    {
        $jfDto = JFDto::fromRequest($request)->validateUpdate();
        $this->jfTaskService->update($jfDto);
    }

    #[Post("/submit")]
    public function submit(Request $request)
    {
        $taskDto = TaskDto::fromRequest($request);
        $this->jfTaskService->submit($taskDto);
    }
}
