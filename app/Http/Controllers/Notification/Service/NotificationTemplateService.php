<?php

namespace App\Http\Controllers\Notification\Service;

use App\Models\Notification\NotificationTemplate;

class NotificationTemplateService extends NotificationTemplate
{

    public function findById($code): ?NotificationTemplateService
    {
        return $this
            ->where('code', $code)
            ->first();
    }

    public function findAll()
    {
        return $this
            ->get();
    }
}
