<?php

namespace Eyegil\WorkflowBase\Services;

use Eyegil\Base\Pageable;
use Eyegil\WorkflowBase\Models\ObjectTask;
use Illuminate\Support\Facades\DB;

class ObjectTaskService
{

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(ObjectTask::class);
    }

    public function findAll()
    {
        return ObjectTask::all();
    }

    public function findById($id)
    {
        return ObjectTask::findOrThrowNotFound($id);
    }

    public function findByProperty($property) {
        return ObjectTask::where('property', $property)->first();
    }

    public function save(array $objectTaskDto)
    {
        return DB::transaction(function () use ($objectTaskDto) {
            $userContext = user_context();
            $objectTaskDto['created_by'] = $userContext->id ?? null;
            return ObjectTask::createWithUuid($objectTaskDto);
        });
    }

    public function update(array $objectTaskDto)
    {
        return DB::transaction(function () use ($objectTaskDto) {
            $userContext = user_context();
            $objectTask = ObjectTask::findOrThrowNotFound($objectTaskDto['id']);
            $objectTask->fill($objectTaskDto);
            $objectTask->updated_by = $userContext->id ?? null;
            $objectTask->save();

            return $objectTask;
        });
    }
}
