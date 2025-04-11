<?php

namespace Eyegil\WorkflowBase\Services;

use Eyegil\Base\Dtos\BaseDto;
use Eyegil\WorkflowBase\Commons\BpmnWFSequence;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\PendingTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkflowService
{
    public function __construct(
        private PendingTaskService $pendingTaskService,
        private ObjectTaskService $objectTaskService,
        private WorkflowValidationService $workflowValidationService,
        private ObjectKeyService $objectKeyService,
    ) {}

    public function findTaskById($pending_task_id)
    {
        return $this->pendingTaskService->findById($pending_task_id);
    }

    public function findTaskByWorkflowNameAndId($workflow_name, $pending_task_id)
    {
        return $this->pendingTaskService->findByWorkflowNameAndId($workflow_name, $pending_task_id);
    }

    public function findTaskByWorkflowNameAndObjectId($workflow_name, $object_id)
    {
        return $this->pendingTaskService->findByWorkflowNameAndObjectId($workflow_name, $object_id);
    }

    public function findTaskByWorkflowNameAndObjectGroup($workflow_name, $object_group)
    {
        return $this->pendingTaskService->findByWorkflowNameAndObjectGroup($workflow_name, $object_group);
    }

    public function startCreateTask($workflow_name, $object_id, $object_name, array $object_keys, BaseDto $object, $object_group = null)
    {
        $userContext = user_context();
        $this->workflowValidationService->validateTaskStart($workflow_name, $object_id, $object_keys, "create");

        return DB::transaction(function () use ($userContext, $workflow_name, $object_id, $object_name, $object_group, $object_keys, $object) {
            $workflow_template = config('eyegil.workflow.templates.' . $workflow_name);

            $bpmnWFSequence = new BpmnWFSequence($workflow_template);
            $bpmnWFSequence->start();
            $processInstance = $bpmnWFSequence->getProcessInstance();

            $objectTask = $this->objectTaskService->save([
                "object" => $object,
            ]);

            $pendingTask = $this->pendingTaskService->save([
                "workflow_name" => $workflow_name,
                "workflow_template" => $workflow_template,
                "object_id" => $object_id,
                "object_name" => $object_name,
                "object_group" => $object_group,
                "workflow_id" => $processInstance->workflow_id,
                "task_type" => "create",
                "instance_id" => $processInstance->id,
                "object_task_id" => $objectTask->id,
                "flow_name" => $processInstance->current_flow_name,
                "flow_id" => $processInstance->current_element_id,
            ]);

            foreach ($object_keys as $key => $value) {
                $this->objectKeyService->save([
                    "object_key" => $key,
                    "object_value" => $value,
                    "pending_task_id" => $pendingTask->id,
                ]);
            }

            // if ($eygine_result->assignee) {
            //     $roles = $eygine_result->assignee->roles;
            //     if ($roles && is_array($roles)) {
            //         foreach ($roles as $key => $value) {
            //             Assignee::createWithUuid([
            //                 'assignee_type' => AssigneeType::ROLE,
            //                 'assignee' => $value,
            //                 'pending_task_id' => $pendingTask->id
            //             ]);
            //         }
            //     }

            //     $users = $eygine_result->assignee->users;
            //     if ($users && is_array($users)) {
            //         foreach ($users as $key => $value) {
            //             Assignee::createWithUuid([
            //                 'assignee_type' => AssigneeType::USER,
            //                 'assignee' => $value,
            //                 'pending_task_id' => $pendingTask->id
            //             ]);
            //         }
            //     }
            // }

            $pendingTask->assignee;
            $pendingTask->pendingTaskHistory;
            return $pendingTask;
        });
    }

    public function startUpdateTask($workflow_name, $object_id, $object_name, array $object_keys, BaseDto $object, BaseDto $object_old, $object_group = null)
    {
        $userContext = user_context();
        $this->workflowValidationService->validateTaskStart($workflow_name, $object_id, $object_keys, "update");

        return DB::transaction(function () use ($userContext, $workflow_name, $object_id, $object_name, $object_group, $object_keys, $object, $object_old) {
            $workflow_template = config('eyegil.workflow.templates.' . $workflow_name);

            $bpmnWFSequence = new BpmnWFSequence($workflow_template);
            $bpmnWFSequence->start();
            $processInstance = $bpmnWFSequence->getProcessInstance();

            $objectTask = $this->objectTaskService->save([
                "object" => $object,
                "object_old" => $object_old,
            ]);

            $pendingTask = $this->pendingTaskService->save([
                "workflow_name" => $workflow_name,
                "workflow_template" => $workflow_template,
                "object_id" => $object_id,
                "object_name" => $object_name,
                "object_group" => $object_group,
                "workflow_id" => $processInstance->workflow_id,
                "task_type" => "update",
                "instance_id" => $processInstance->id,
                "object_task_id" => $objectTask->id,
                "flow_name" => $processInstance->current_flow_name,
                "flow_id" => $processInstance->current_element_id,
            ]);

            foreach ($object_keys as $key => $value) {
                $this->objectKeyService->save([
                    "object_key" => $key,
                    "object_value" => $value,
                    "pending_task_id" => $pendingTask->id,
                ]);
            }

            // if ($eygine_result->assignee) {
            //     $roles = $eygine_result->assignee->roles;
            //     if ($roles && is_array($roles)) {
            //         foreach ($roles as $key => $value) {
            //             Assignee::createWithUuid([
            //                 'assignee_type' => AssigneeType::ROLE,
            //                 'assignee' => $value,
            //                 'pending_task_id' => $pendingTask->id
            //             ]);
            //         }
            //     }

            //     $users = $eygine_result->assignee->users;
            //     if ($users && is_array($users)) {
            //         foreach ($users as $key => $value) {
            //             Assignee::createWithUuid([
            //                 'assignee_type' => AssigneeType::USER,
            //                 'assignee' => $value,
            //                 'pending_task_id' => $pendingTask->id
            //             ]);
            //         }
            //     }
            // }

            $pendingTask->assignee;
            $pendingTask->pendingTaskHistory;
            return $pendingTask;
        });
    }

    public function startDeleteTask($workflow_name, $object_id, $object_name, array $object_keys, BaseDto $object, $object_group = null)
    {
        $userContext = user_context();
        $this->workflowValidationService->validateTaskStart($workflow_name, $object_id, $object_keys, "delete");

        return DB::transaction(function () use ($userContext, $workflow_name, $object_id, $object_name, $object_group, $object_keys, $object) {
            $workflow_template = config('eyegil.workflow.templates.' . $workflow_name);

            $bpmnWFSequence = new BpmnWFSequence($workflow_template);
            $bpmnWFSequence->start();
            $processInstance = $bpmnWFSequence->getProcessInstance();

            $objectTask = $this->objectTaskService->save([
                "object" => $object,
            ]);

            $pendingTask = $this->pendingTaskService->save([
                "workflow_name" => $workflow_name,
                "workflow_template" => $workflow_template,
                "object_id" => $object_id,
                "object_name" => $object_name,
                "object_group" => $object_group,
                "object" => $object,
                "workflow_id" => $processInstance->workflow_id,
                "task_type" => "delete",
                "instance_id" => $processInstance->id,
                "object_task_id" => $objectTask->id,
                "flow_name" => $processInstance->current_flow_name,
                "flow_id" => $processInstance->current_element_id,
            ]);

            foreach ($object_keys as $key => $value) {
                $this->objectKeyService->save([
                    "object_key" => $key,
                    "object_value" => $value,
                    "pending_task_id" => $pendingTask->id,
                ]);
            }

            // if ($eygine_result->assignee) {
            //     $roles = $eygine_result->assignee->roles;
            //     if ($roles && is_array($roles)) {
            //         foreach ($roles as $key => $value) {
            //             Assignee::createWithUuid([
            //                 'assignee_type' => AssigneeType::ROLE,
            //                 'assignee' => $value,
            //                 'pending_task_id' => $pendingTask->id
            //             ]);
            //         }
            //     }

            //     $users = $eygine_result->assignee->users;
            //     if ($users && is_array($users)) {
            //         foreach ($users as $key => $value) {
            //             Assignee::createWithUuid([
            //                 'assignee_type' => AssigneeType::USER,
            //                 'assignee' => $value,
            //                 'pending_task_id' => $pendingTask->id
            //             ]);
            //         }
            //     }
            // }

            $pendingTask->assignee;
            $pendingTask->pendingTaskHistory;
            return $pendingTask;
        });
    }

    public function submitTask($id, $task_action, $object = null, $remark = null)
    {
        $userContext = user_context();
        return DB::transaction(function () use ($id, $task_action, $userContext, $object, $remark) {
            $pendingTask = $this->pendingTaskService->findById($id);
            $this->workflowValidationService->validateTaskSubmit($pendingTask);

            $bpmnWFSequence = new BpmnWFSequence($pendingTask->workflow_template, $pendingTask->instance_id);
            $bpmnWFSequence->next([
                'action' => $task_action
            ]);
            $processInstance = $bpmnWFSequence->getProcessInstance();

            $pendingTask->task_action = $task_action;
            $pendingTask->task_status = TaskStatus::COMPLETED->name;
            $pendingTask->updated_by = optional($userContext)->id ?? null;
            $pendingTask->save();

            if ($processInstance->is_completed) {
                // $pendingTask->objectTask;
                // return $pendingTask;
                $objectTask = null;
                if ($object) {
                    $objectTask = $this->objectTaskService->save([
                        "object" => $object,
                        "prev_object" => $pendingTask->objectTask->object,
                        "old_object" => $pendingTask->objectTask->prev_object,
                    ]);
                } else {
                    $objectTask = $this->objectTaskService->save([
                        "object" => $pendingTask->objectTask->object,
                        "old_object" => $pendingTask->objectTask->prev_object,
                    ]);
                }

                Log::info('WorkflowService.submitTask.$processInstance :: ' . json_encode($processInstance->toArray()));

                $pendingTaskDto = $pendingTask->toArray();
                $pendingTaskDto['id'] = null;
                $pendingTaskDto['last_updated'] = null;
                $pendingTaskDto['updated_by'] = null;
                $pendingTaskDto['workflow_id'] = null;
                $pendingTaskDto['instance_id'] = null;
                $pendingTaskDto['remark'] = $remark;
                $pendingTaskDto['task_status'] = $task_action == "reject" ? TaskStatus::FAILED->name : TaskStatus::COMPLETED->name;
                $pendingTaskDto['workflow_id'] = $processInstance->workflow_id;
                $pendingTaskDto['instance_id'] = $processInstance->id;
                $pendingTaskDto['object_task_id'] = $objectTask->id;

                if ($pendingTaskDto['task_type'] == 'create')
                    $pendingTaskDto['created_by'] = optional($userContext)->id || null;
                else
                    $pendingTaskDto['updated_by'] = optional($userContext)->id || null;
                $pendingTask_new = PendingTask::createWithUuid($pendingTaskDto);

                foreach ($pendingTask->objectKeyList as $key => $objectKey) {
                    $this->objectKeyService->save([
                        "object_key" => $objectKey->object_key,
                        "object_value" => $objectKey->object_value,
                        "pending_task_id" => $pendingTask_new->id,
                    ]);
                }

                // if ($eygine_result->assignee) {
                //     $roles = $eygine_result->assignee->roles;
                //     if ($roles && is_array($roles)) {
                //         foreach ($roles as $key => $value) {
                //             Assignee::createWithUuid([
                //                 'assignee_type' => AssigneeType::ROLE,
                //                 'assignee' => $value,
                //                 'pending_task_id' => $pendingTask_new->id
                //             ]);
                //         }
                //     }

                //     $users = $eygine_result->assignee->users;
                //     if ($users && is_array($users)) {
                //         foreach ($users as $key => $value) {
                //             Assignee::createWithUuid([
                //                 'assignee_type' => AssigneeType::USER,
                //                 'assignee' => $value,
                //                 'pending_task_id' => $pendingTask_new->id
                //             ]);
                //         }
                //     }
                // }

                $pendingTask_new->objectTask;
                $pendingTask_new->assignee;
                $pendingTask_new->pendingTaskHistory;
                return $pendingTask_new;
            } else {
                $objectTask = null;
                if ($object) {
                    $objectTask = $this->objectTaskService->save([
                        "object" => $object,
                        "prev_object" => $pendingTask->objectTask->object,
                        "old_object" => $pendingTask->objectTask->prev_object,
                    ]);
                } else {
                    $objectTask = $this->objectTaskService->save([
                        "object" => $pendingTask->objectTask->object,
                        "old_object" => $pendingTask->objectTask->prev_object,
                    ]);
                }

                Log::info('WorkflowService.submitTask.$processInstance :: ' . json_encode($processInstance->toArray()));

                $pendingTaskDto = $pendingTask->toArray();
                $pendingTaskDto['id'] = null;
                $pendingTaskDto['last_updated'] = null;
                $pendingTaskDto['updated_by'] = null;
                $pendingTaskDto['workflow_id'] = null;
                $pendingTaskDto['instance_id'] = null;
                $pendingTaskDto['task_action'] = null;
                $pendingTaskDto['remark'] = $remark;
                $pendingTaskDto['task_status'] = TaskStatus::PENDING->name;
                $pendingTaskDto['workflow_id'] = $processInstance->workflow_id;
                $pendingTaskDto['instance_id'] = $processInstance->id;
                $pendingTaskDto['flow_name'] = $processInstance->current_flow_name;
                $pendingTaskDto['flow_id'] = $processInstance->current_element_id;
                $pendingTaskDto['object_task_id'] = $objectTask->id;

                if ($pendingTaskDto['task_type'] == 'create')
                    $pendingTaskDto['created_by'] = optional($userContext)->id || null;
                else
                    $pendingTaskDto['updated_by'] = optional($userContext)->id || null;
                $pendingTask_new = PendingTask::createWithUuid($pendingTaskDto);

                foreach ($pendingTask->objectKeyList as $key => $objectKey) {
                    $this->objectKeyService->save([
                        "object_key" => $objectKey->object_key,
                        "object_value" => $objectKey->object_value,
                        "pending_task_id" => $pendingTask_new->id,
                    ]);
                }

                // if ($eygine_result->assignee) {
                //     $roles = $eygine_result->assignee->roles;
                //     if ($roles && is_array($roles)) {
                //         foreach ($roles as $key => $value) {
                //             Assignee::createWithUuid([
                //                 'assignee_type' => AssigneeType::ROLE,
                //                 'assignee' => $value,
                //                 'pending_task_id' => $pendingTask_new->id
                //             ]);
                //         }
                //     }

                //     $users = $eygine_result->assignee->users;
                //     if ($users && is_array($users)) {
                //         foreach ($users as $key => $value) {
                //             Assignee::createWithUuid([
                //                 'assignee_type' => AssigneeType::USER,
                //                 'assignee' => $value,
                //                 'pending_task_id' => $pendingTask_new->id
                //             ]);
                //         }
                //     }
                // }

                $pendingTask_new->objectTask;
                $pendingTask_new->assignee;
                $pendingTask_new->pendingTaskHistory;
                return $pendingTask_new;
            }
        });
    }

    public function stopTask() {}
}
