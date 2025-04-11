<?php

namespace Eyegil\SecurityBase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SecurityBase\Services\AuthenticationTypeService;
use Illuminate\Http\Request;

#[Controller("/api/v1/authentication_type")]
class AuthenticationTypeController
{
    public function __construct(
        private AuthenticationTypeService $authenticationTypeService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->authenticationTypeService->findAll();
    }

    #[Get("/{code")]
    public function findByCode(Request $request)
    {
        return $this->authenticationTypeService->findByCode($request->code);
    }
}
