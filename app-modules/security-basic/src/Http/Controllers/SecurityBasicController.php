<?php

namespace Eyegil\SecurityBasic\Http\Controllers;

use Eyegil\SecurityBase\Services\AuthenticationServiceMap;
use Illuminate\Http\Request;

class SecurityBasicController
{
    public function __construct(
        private AuthenticationServiceMap $authenticationServiceMap
    ) {}

    public function authenticate(Request $request)
    {
        $application_code = $request->application_code ?? $request->client_id;
        $loginContext = $this->authenticationServiceMap->get($application_code)->login($request->user_id, $request->password);

        return $loginContext;
    }
}
