<?php

namespace Eyegil\WorkflowBase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Pageable;
use Eyegil\WorkflowBase\Commons\Bpmn2;
use Eyegil\WorkflowBase\Services\PendingTaskService;
use Illuminate\Http\Request;

#[Controller("/api/v1/pending_task")]
class PendingTaskController
{
    public function __construct(
        private PendingTaskService $pendingTaskService
    ) {}

    #[Get("/detail")]
    public function getTaskDetail(Request $request)
    {
        return $this->pendingTaskService->getTaskDetail($request->id);
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->pendingTaskService->findSearch(new Pageable($request->query()));
    }

    #[Get()]
    public function findAll()
    {
        return $this->pendingTaskService->findAll();
    }

    #[Get("/{id}")]
    public function findById(Request $request)
    {
        return $this->pendingTaskService->findById($request->id);
    }

    #[Get("/wf_name/{workflow_name}/{object_id}")]
    public function findByWorkflowNameAndObjectId(Request $request)
    {
        return $this->pendingTaskService->findByWorkflowNameAndObjectId($request->workflow_name, $request->object_id);
    }

    #[Delete("/delete/{instance_id}")]
    public function deleteWholeTask($instance_id)
    {
        return $this->pendingTaskService->deleteWholeTask($instance_id);
    }
}
