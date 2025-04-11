<?php

namespace Eyegil\SecurityBase\Services;

class AuthenticationServiceMap
{
    protected $map;

    public function __construct(array $initialData = [])
    {
        $this->map = $initialData;
    }

    public function put($key, IAuthenticationService $value)
    {
        $this->map[$key] = $value;
    }

    public function get($key): IAuthenticationService
    {
        return $this->map[$key];
    }

    public function all()
    {
        return $this->map;
    }

    public function remove($key)
    {
        unset($this->map[$key]);
    }
}
