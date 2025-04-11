<?php

namespace Eyegil\SecurityBase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SecurityBase\Services\ApplicationService;
use Illuminate\Http\Request;

#[Controller("/api/v1/application")]
class ApplicationController
{

    public function __construct(
        private ApplicationService $applicationService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->applicationService->findAll();
    }

    #[Get("/{code}")]
    public function findByCode(Request $request)
    {
        return $this->applicationService->findByCode($request->code);
    }
}
