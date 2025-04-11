<?php

namespace Eyegil\WorkflowBase\Services;

use Eyegil\WorkflowBase\Models\Flows;

class PendingTaskState
{
    private $state;
    private array $events;

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setEvents(array $events)
    {
        return $this->events = $events;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function getEvent($name)
    {
        return isset($this->events[$name]) ? $this->events[$name] : null;
    }
}
