<?php

namespace Eyegil\WorkflowBase\Commons;

use Eyegil\WorkflowBase\Commons\Bpmn2;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\WorkflowBase\Models\ProcessInstance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BpmnWFSequence
{
    private $workflowInstanceId;
    private $workflowData;
    private $currentElement;
    private $currentVariables;

    private $processInstance;

    public function __construct($wfName, $id = null)
    {
        DB::transaction(function () use ($wfName, $id) {
            $processInstance = null;

            if ($id) {
                $processInstance = ProcessInstance::findOrThrowNotFound($id);
            } else {
                $bpmn2 = new Bpmn2();
                $processInstance = new ProcessInstance();
                $processInstance->workflow_id = $wfName;
                $processInstance->workflow_data = $bpmn2->parseBpmnXml(config("eyegil.workflow.$wfName"));
                $processInstance->current_element_id = $processInstance->workflow_data['elements']['startEvents'][0]['id'];
                $processInstance->current_variables = null;
                $processInstance->saveWithUUid();
            }

            $this->workflowInstanceId = $processInstance->id;
            $this->workflowData = $processInstance->workflow_data;
            $this->currentElement = $this->findElementById($processInstance->current_element_id);
            $this->currentVariables = $processInstance->current_variables;
            $this->processInstance = $processInstance;
        });
    }

    public function  getProcessInstance()
    {
        return $this->processInstance;
    }

    public function start(array $variables = null): BpmnWFSequence
    {
        $this->currentElement = $this->workflowData['elements']['startEvents'][0];
        return $this->next($variables);
    }

    public function next(array $variables = null): BpmnWFSequence
    {
        // Check if the current element is an end event
        if ($this->isEndEvent($this->currentElement['id'])) {
            throw new BusinessException("Cannot proceed: Current element is an end event with ID: " . $this->currentElement['id'], "BPMN-00001");
        }

        $isFirstIteration = true;
        while ($this->currentElement) {
            Log::info("Current Element: " . $this->currentElement['id']);

            if ($isFirstIteration) {
                $isFirstIteration = false;
            } elseif ($this->isEndEvent($this->currentElement['id'])) {
                $this->saveCurrentState();
                Log::info("Stopped at end element: " . $this->currentElement['id']);
                return $this; 
            } elseif ($this->isTaskElement($this->currentElement['id'])) {
                $this->saveCurrentState();
                Log::info("Stopped at task element: " . $this->currentElement['id']);
                return $this; 
            }

            $this->handleOutgoingElements($variables);
        }

        return $this;
    }

    private function handleOutgoingElements(array $variables = null)
    {
        foreach ($this->currentElement['outgoings'] as $elementId) {
            $nextElement = $this->findElementById($elementId);

            if (!$nextElement) {
                Log::warning("No next element found for outgoing: " . $elementId);
                continue; // Skip this iteration if no next element is found
            }

            if (isset($nextElement['condition']) && $nextElement['condition'] !== null) {
                if (empty($variables)) {
                    throw new BusinessException("Condition's variables were not set", "BPMN-00002");
                }

                if ($this->evalCondition($nextElement['condition']['expression'], $variables)) {
                    $this->currentElement = $this->findElementById($this->findElementById($nextElement['target'])['id']);
                    return;
                }
            } else {
                $this->currentElement = $this->findElementById($this->findElementById($nextElement['target'])['id']);
                return; // Move to next element if no conditions apply
            }
        }

        throw new BusinessException("No valid outgoing flow found", "BPMN-00003");
    }

    private function isTaskElement($elementId): bool
    {
        $taskTypes = ['userTasks', 'serviceTasks', 'scriptTasks'];
        foreach ($taskTypes as $taskType) {
            if (isset($this->workflowData['elements'][$taskType])) {
                $taskIds = array_column($this->workflowData['elements'][$taskType], 'id');
                if (in_array($elementId, $taskIds)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function isSequenceFlowElement($elementId): bool
    {
        if (isset($this->workflowData['elements']["sequenceFlows"])) {
            $taskIds = array_column($this->workflowData['elements']["sequenceFlows"], 'id');
            if (in_array($elementId, $taskIds)) {
                return true;
            }
        }
        return false;
    }

    private function findElementById($id)
    {
        foreach ($this->workflowData['elements'] as $type => $elements) {
            foreach ($elements as $element) {
                if ($element['id'] === $id) {
                    return $element;
                }
            }
        }
        return null;
    }

    private function evalCondition($expression, $variables)
    {
        if (empty($expression)) {
            throw new BusinessException("Empty condition expression", "BPMN-00004");
        }

        extract($variables);
        return eval('return ' . $expression . ';');
    }

    private function isEndEvent($elementId)
    {
        foreach ($this->workflowData['elements']['endEvents'] as $endEvent) {
            if ($endEvent['id'] === $elementId) {
                return true;
            }
        }
        return false;
    }

    private function saveCurrentState()
    {
        DB::transaction(function () {
            $processInstance = ProcessInstance::findOrThrowNotFound($this->workflowInstanceId);
            $processInstance->current_element_id = $this->currentElement['id'];
            $processInstance->current_variables = $this->currentVariables;
            $processInstance->is_completed = $this->isEndEvent($this->currentElement['id']);
            $processInstance->current_flow_name = $this->currentElement['name'] ?? null;
            $processInstance->save();

            $this->workflowInstanceId = $processInstance->id;
            $this->workflowData = $processInstance->workflow_data;
            $this->currentVariables = $processInstance->current_variables;
            $this->processInstance = $processInstance;
        });
    }
}
