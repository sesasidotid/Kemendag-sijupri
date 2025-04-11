<?php

namespace Eyegil\SecurityOauth2\Http\Controllers;

use Eyegil\SecurityBase\Services\ApplicationService;
use Illuminate\Http\Request;

class Oauth2Controller
{
    private ApplicationService $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function get_findAll()
    {
        return $this->applicationService->findAll();
    }

    public function get_findByCode(Request $request)
    {
        return $this->applicationService->findByCode($request->code);
    }
}
