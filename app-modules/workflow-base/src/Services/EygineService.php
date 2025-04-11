<?php

namespace Eyegil\WorkflowBase\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Eyegil\WorkflowBase\Models\Workflow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EygineService extends TemplateWF
{
    private $workflowEg;

    public function startFlow($template_code)
    {
        $pendingTaskState = new PendingTaskState();
        $pendingTaskState->setState('start');
        $this->workflowEg = $this->createWorkflow($template_code);

        if ($this->workflowEg->can($pendingTaskState, 'create')) {
            $this->workflowEg->apply($pendingTaskState, 'create');
        }

        $assigneeOptions = (object) $this->flow_list[0];
        $instance_id = Str::uuid();
        Log::info("Workflow started with instance id : $instance_id");
        $workflow = Workflow::createWithUuid([
            "instance_id" => $instance_id,
            "task_id" => $template_code,
            "state" => $pendingTaskState->getState(),
            "context" => (object) [
                "flow_list" => $this->flow_list,
                "is_completed" => $this->is_completed,
                "is_stoped" => $this->is_stoped
            ],
            "status" => TaskStatus::PENDING->name,
        ]);

        return (object) [
            "state" => $pendingTaskState->getState(),
            "workflow" => $workflow,
            "flow_name" => $assigneeOptions->name,
            "assignee" => (object) [
                "roles" => $assigneeOptions->roleToExe ?? [],
                "users" => $assigneeOptions->userToExe ?? []
            ]
        ];
    }

    public function sendEvent($template_code, $workflow_id, array $events = [])
    {
        $workflow = Workflow::findOrThrowNotFound($workflow_id);
        $pendingTaskState = new PendingTaskState();
        $pendingTaskState->setState('initialProcess');
        $pendingTaskState->setEvents($events);
        $this->workflowEg = $this->createWorkflow($template_code, $workflow->context);

        if ($this->is_stoped)
            throw new BusinessException('Workflow has already stopped.', "EWF-00001");
        else if ($this->is_completed)
            throw new BusinessException('Workflow has already completed.', "EWF-00001");

        if ($this->workflowEg->can($pendingTaskState, 'submit')) {
            $this->workflowEg->apply($pendingTaskState, 'submit');
        }

        $workflow->status = TaskStatus::COMPLETED->name;
        $workflow->state = $pendingTaskState->getState();
        $workflow->context = [
            "flow_list" => $this->flow_list,
            "is_completed" => $this->is_completed,
            "is_stoped" => $this->is_stoped
        ];
        $workflow->save();

        $assigneeOptions = (object) $this->flow_list[0];
        if (!$this->is_completed) {
            $workflow = Workflow::createWithUuid([
                "instance_id" => $workflow->instance_id,
                "task_id" => $template_code,
                "state" => $pendingTaskState->getState(),
                "context" => (object) [
                    "flow_list" => $this->flow_list,
                    "is_completed" => $this->is_completed,
                    "is_stoped" => $this->is_stoped
                ],
                "status" => TaskStatus::PENDING->name,
            ]);

            return (object) [
                "workflow" => $workflow,
                "flow_name" => $assigneeOptions->name ?? null,
                "assignee" => (object) [
                    "roles" => $assigneeOptions->roleToExe ?? [],
                    "users" => $assigneeOptions->userToExe ?? []
                ],
                "context" => (object) $workflow->context
            ];
        }

        return (object) [
            "workflow" => $workflow,
            "flow_name" => $assigneeOptions->name ?? null,
            "context" => (object) $workflow->context
        ];
    }
}
