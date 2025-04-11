<?php

namespace Eyegil\NotificationBase\Services;

use Eyegil\NotificationBase\Models\NotificationTopic;

class NotificationTopicService
{
    public function findById($id)
    {
        return NotificationTopic::findOrThrowNotFound($id);
    }

    public function findByRoleCodeList(array $role_code_list)
    {
        return NotificationTopic::whereNull("role_code")
            ->orWhereIn('role_code', $role_code_list)
            ->get();
    }
}
