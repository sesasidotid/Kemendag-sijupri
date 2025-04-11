<?php

namespace Eyegil\NotificationBase\Dtos;


class NotificationOptions
{
    public $priority = 0;
    public $expiry_date;

    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    public function setExpiryDate($expiry_date)
    {
        $this->expiry_date = $expiry_date;
        return $this;
    }
}
