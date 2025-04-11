<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\SecurityBase\Models\AuthenticationType;

class AuthenticationTypeService
{

    public function __construct()
    {
    }

    public function findAll()
    {
        return AuthenticationType::all();
    }

    public function findByCode(string $code): AuthenticationType
    {
        return AuthenticationType::findOrThrowNotFound($code);
    }
}
