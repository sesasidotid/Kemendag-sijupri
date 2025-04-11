<?php

namespace Eyegil\WorkflowBase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\WorkflowBase\Services\ObjectTaskService;
use Illuminate\Http\Request;

#[Controller("/api/v1/object_task")]
class ObjectTaskController
{
    public function __construct(
        private ObjectTaskService $objectTaskService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->objectTaskService->findAll();
    }

    #[Get("/{id}")]
    public function findById(Request $request)
    {
        return $this->objectTaskService->findById($request->id);
    }
}
