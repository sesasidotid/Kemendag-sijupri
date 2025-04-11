<?php

namespace Eyegil\NotificationBase\Services;

class NotificationServiceMap
{
    protected $map;

    public function __construct(array $initialData = [])
    {
        $this->map = $initialData;
    }

    public function put($key, INotificationService $value)
    {
        $this->map[$key] = $value;
    }

    public function get($key): INotificationService
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
