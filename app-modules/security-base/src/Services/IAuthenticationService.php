<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\SecurityBase\LoginContext;

interface IAuthenticationService
{

    public function login(string $userId, string $password, $options = null): LoginContext;

    public function register(string $userId, string $password, $options = null);
}
