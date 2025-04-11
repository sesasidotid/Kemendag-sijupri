<?php

namespace Eyegil\WorkflowBase\Services;

use Eyegil\WorkflowBase\Models\ObjectKey;
use Illuminate\Support\Facades\DB;

class ObjectKeyService
{

    public function save($objectKeyDto)
    {
        return DB::transaction(function () use ($objectKeyDto) {
            return ObjectKey::createWithUuid($objectKeyDto);
        });
    }
}
