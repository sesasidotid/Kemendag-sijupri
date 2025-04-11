<?php

namespace Eyegil\WorkflowBase\Services;

use Eyegil\Base\Pageable;
use Eyegil\WorkflowBase\Dtos\TaskDetailDto;
use Eyegil\WorkflowBase\Dtos\TaskHistoryDto;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\ObjectTask;
use Eyegil\WorkflowBase\Models\PendingTask;
use Eyegil\WorkflowBase\Models\ProcessInstance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendingTaskService
{

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(PendingTask::class);
    }

    public function findAll()
    {
        return PendingTask::all();
    }

    public function findById($id)
    {
        return PendingTask::with("objectTask")->where('id', $id)->firstOrThrowNotFound();
    }

    public function findByWorkflowNameAndId($workflow_name, $id)
    {
        return PendingTask::with("objectTask")->where("workflow_name", $workflow_name)->where('id', $id)->firstOrThrowNotFound();
    }

    public function findByWorkflowNameAndObjectId($workflow_name, $object_id)
    {
        $pendingTask = PendingTask::with("objectTask")->where("workflow_name", $workflow_name)
            ->where("object_id", $object_id)
            ->where("task_status", TaskStatus::PENDING->name)
            ->firstOrThrowNotFound();
        $pendingTask->assignee;
        $pendingTask->pendingTaskHistory;
        return $pendingTask;
    }

    public function findByWorkflowNameAndObjectGroup($workflow_name, $object_group)
    {
        $pendingTask = PendingTask::with("objectTask")->where("workflow_name", $workflow_name)
            ->where("object_group", $object_group)
            ->where("task_status", TaskStatus::PENDING->name)
            ->firstOrThrowNotFound();
        $pendingTask->assignee;
        $pendingTask->pendingTaskHistory;
        return $pendingTask;
    }

    public function findByInstanceId($instance_id)
    {
        return PendingTask::where('instance_id', $instance_id)
            ->latest('date_created')
            ->get();
    }

    public function findByObjectIdAndTaskStatusPending($object_id): ?PendingTask
    {
        return PendingTask::with("objectTask")->where('object_id', $object_id)
            ->where('task_status', TaskStatus::PENDING->name)
            ->firstOrThrowNotFound();
    }

    public function findByTaskStatusPending()
    {
        return PendingTask::where('task_status', TaskStatus::PENDING->name)->first();
    }

    public function findLatestInstanceId($instance_id)
    {
        return PendingTask::where('instance_id', $instance_id)
            ->latest('date_created')
            ->first();
    }

    public function findByWorkflowNameAndObjectIdAndTaskStatus($workflow_name, $object_id, $task_status)
    {
        return PendingTask::where('workflow_name', $workflow_name)
            ->where('object_id', $object_id)
            ->where('task_status', $task_status)
            ->first();
    }

    public function findByObjectKeysAndWorkflowNameAndStatusPending(array $objectKeys, $workflow_name)
    {
        return PendingTask::whereHas('objectKeyList', function ($query) use ($objectKeys) {
            foreach ($objectKeys as $key => $value) {
                $query->where(function ($q) use ($key, $value) {
                    $q->where('object_key', $key)
                        ->where('object_value', $value);
                });
            }
        })->where("workflow_name", $workflow_name)->where("task_status", TaskStatus::PENDING)->get();
    }

    public function getTaskDetail($id)
    {
        $taskDetailDto = new TaskDetailDto();
        $taskDetailDto->fromArray($this->findById($id)->toArray());
        foreach ($this->findByInstanceId($taskDetailDto->instance_id) as $key => $pendingTask) {
            $taskHistoryDto = new TaskHistoryDto();
            $taskHistoryDto->fromArray($pendingTask->toArray());
            $taskDetailDto->task_history_list[] = $taskHistoryDto;
        }

        return $taskDetailDto->toArray();
    }

    public function save(array $pendingTaskDto)
    {
        return DB::transaction(function () use ($pendingTaskDto) {
            $userContext = user_context();
            $pendingTaskDto['created_by'] = $userContext->id ?? null;
            return PendingTask::createWithUuid($pendingTaskDto);
        });
    }

    public function update(array $pendingTaskDto)
    {
        return DB::transaction(function () use ($pendingTaskDto) {
            $pendingTask = PendingTask::findOrThrowNotFound($pendingTaskDto['id']);
            $pendingTask->fromArray($pendingTaskDto);
            $pendingTask->delete_flag = true;
            $pendingTask->updated_by = user_context()->id || null;
            $pendingTask->save();

            return $pendingTask;
        });
    }

    public function delete(string $id)
    {
        return DB::transaction(function () use ($id) {
            $pendingTask = PendingTask::findOrThrowNotFound($id);

            $pendingTask->delete_flag = true;
            $pendingTask->updated_by = user_context()->id || null;
            $pendingTask->save();

            return $pendingTask;
        });
    }

    public function deleteWholeTask($instance_id)
    {
        return DB::transaction(function () use ($instance_id) {
            $query = PendingTask::where("instance_id", $instance_id);
            $objectTaskIdList = $query->get()->map(function (PendingTask $pendingTask) {
                return $pendingTask->object_task_id ?? "";
            })->toArray();
            $query->delete();
            ProcessInstance::where("id", $instance_id)->delete();
            ObjectTask::whereIn("id", $objectTaskIdList)->delete();
        });
    }
}
