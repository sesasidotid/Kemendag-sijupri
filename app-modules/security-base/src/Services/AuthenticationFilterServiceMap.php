<?php

namespace Eyegil\SecurityBase\Services;

class AuthenticationFilterServiceMap
{
    protected $map;

    public function __construct(array $initialData = [])
    {
        $this->map = $initialData;
    }

    public function put($key, IAuthenticationFilterService $value)
    {
        $this->map[$key] = $value;
    }

    public function get($key): IAuthenticationFilterService
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
