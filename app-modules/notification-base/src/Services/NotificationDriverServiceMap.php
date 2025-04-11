<?php

namespace Eyegil\NotificationBase\Services;

class NotificationDriverServiceMap
{
    protected $map;

    public function __construct(array $initialData = [])
    {
        $this->map = $initialData;
    }

    public function put($key, INotificationDriverService $value)
    {
        $this->map[$key] = $value;
    }

    public function get($key): INotificationDriverService
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
