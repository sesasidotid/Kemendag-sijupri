<?php

namespace Eyegil\WorkflowBase\Services;

use Eyegil\WorkflowBase\Enums\TaskAction;
use Eyegil\WorkflowBase\Models\Flows;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\GuardEvent;

class TemplateWF
{
    protected $flow_list;
    protected $prev_flow_list;
    protected $is_completed = false;
    protected $is_stoped = false;
    protected $is_amend = false;
    protected $is_rework = false;

    protected function createWorkflow(string $code, $context = null)
    {
        if ($context) {
            $this->flow_list = $context->flow_list ?? [];
            $this->prev_flow_list = $context->prev_flow_list ?? [];
            $this->is_completed = $context->is_completed;
            $this->is_stoped = $context->is_stoped;
        } else {
            $workfloConfig = config('eyegil.workflow');
            $flows = $workfloConfig['wf_templates'][$code]->flows;
            $this->flow_list = $flows->flow_list;
        }

        $definitionBuilder = new DefinitionBuilder();
        $definitionBuilder->addPlaces(['start', 'initialProcess', 'setTimer', 'conditionsCheck', 'conditions', 'finishedCheck', 'finished', 'stoped']);
        $definitionBuilder->addTransition(new Transition('create', 'start', 'setTimer'));
        $definitionBuilder->addTransition(new Transition('create', 'start', 'initialProcess'));
        $definitionBuilder->addTransition(new Transition('submit', 'initialProcess', 'stoped'));
        $definitionBuilder->addTransition(new Transition('submit', 'initialProcess', 'conditionsCheck'));
        $definitionBuilder->addTransition(new Transition('_finish', 'conditionsCheck', 'finishedCheck'));
        $definitionBuilder->addTransition(new Transition('_cond_check', 'conditionsCheck', 'setTimer'));
        $definitionBuilder->addTransition(new Transition('_cond_check', 'conditionsCheck', 'initialProcess'));
        $definitionBuilder->addTransition(new Transition('_timer', 'setTimer', 'initialProcess'));
        $definitionBuilder->addTransition(new Transition('_finish_check', 'finishedCheck', 'finished'));
        $definition = $definitionBuilder->build();
        $dispatcher = new EventDispatcher();

        $dispatcher->addListener('workflow.guard', function (GuardEvent $event) {
            $subject = $event->getSubject();
            $transition = $event->getTransition();
            Log::info("Guard Check: Transition '{$transition->getName()}' from '{$subject->getState()}' to " . implode(', ', $transition->getTos()));

            switch ($transition->getName()) {
                case 'create':
                    if (in_array('setTimer', $transition->getTos()) && $this->isTimerExist()) {
                        $event->setBlocked(false);
                    } elseif (in_array('initialProcess', $transition->getTos())) {
                        $event->setBlocked(false);
                    } else {
                        $event->setBlocked(true);
                    }
                    break;
                case 'submit':
                    $subject = $event->getSubject();
                    if ($subject->getEvent('action') == TaskAction::APPROVE->value) {
                        if (in_array('conditionsCheck', $transition->getTos())) {
                            $event->setBlocked(false);
                        } else {
                            $event->setBlocked(true);
                        }
                    } else if ($subject->getEvent('action') == TaskAction::REWORK->value) {
                        if (in_array('conditionsCheck', $transition->getTos())) {
                            $this->is_rework = true;
                            $event->setBlocked(false);
                        } else {
                            $event->setBlocked(true);
                        }
                    } else if ($subject->getEvent('action') == TaskAction::AMEND->value) {
                        if (in_array('conditionsCheck', $transition->getTos())) {
                            $this->is_amend = true;
                            $event->setBlocked(false);
                        } else {
                            $event->setBlocked(true);
                        }
                    } else if ($subject->getEvent('action') == TaskAction::REJECT->value) {
                        if (in_array('stoped', $transition->getTos())) {
                            $event->setBlocked(false);
                        } else {
                            $event->setBlocked(true);
                        }
                    } else {
                        $event->setBlocked(true);
                    }
                    break;
                case '_cond_check':
                    if (in_array('setTimer', $transition->getTos())) {
                        $event->setBlocked(!$this->isTimerExist());
                    } elseif (in_array('initialProcess', $transition->getTos())) {
                        $event->setBlocked(false);
                    } else {
                        $event->setBlocked(true);
                    }
                    break;
            }
        });

        $dispatcher->addListener('workflow.entered', function (Event $event) use ($context) {
            $subject = $event->getSubject();
            $workflow = $event->getWorkflow();
            Log::info("Entered State: " . $subject->getState());

            switch ($subject->getState()) {
                case 'initialProcess': {
                        if ($context) array_shift($this->flow_list);
                    }
                case 'conditionsCheck':
                    if ($this->is_amend) {
                        if ($workflow->can($subject, '_cond_check')) {
                            $this->is_amend = false;
                            $workflow->apply($subject, '_cond_check');
                        }
                    } else if ($this->is_rework) {
                        if ($workflow->can($subject, '_cond_check')) {
                            array_unshift($this->flow_list, $this->prev_flow_list[0]);
                            array_shift($this->prev_flow_list);
                            $this->is_rework = false;
                            $workflow->apply($subject, '_cond_check');
                        }
                    } else {
                        if (count($this->flow_list) == 0) {
                            if ($workflow->can($subject, '_finish')) {
                                array_shift($this->flow_list);
                                $workflow->apply($subject, '_finish');
                            }
                        } else {
                            if ($workflow->can($subject, '_cond_check')) {
                                array_shift($this->flow_list);
                                $workflow->apply($subject, '_cond_check');
                            }
                        }
                    }
                    break;
                case 'setTimer':
                    if ($workflow->can($subject, '_timer')) {
                        $workflow->apply($subject, '_timer');
                    }
                    break;
                case 'finishedCheck':
                    if ($workflow->can($subject, '_finish_check')) {
                        $workflow->apply($subject, '_finish_check');
                    }
                    break;
                case 'finished':
                    $this->is_completed = true;
                    break;
                case 'stoped':
                    $this->is_stoped = true;
                    break;
            }
        });

        $dispatcher->addListener('workflow.enter', function (Event $event) {});

        $dispatcher->addListener('workflow.leave', function (Event $event) {});

        $dispatcher->addListener('workflow.transition', function (Event $event) {});

        $dispatcher->addListener('workflow.completed', function (Event $event) {});

        $markingStore = new MethodMarkingStore(true, 'state');
        return new Workflow($definition, $markingStore, $dispatcher);
    }

    private function isTimerExist(): bool
    {
        if ($this->isFlowExist()) {
            $flow = $this->getCurrentFlow();
            if (isset($flow->timed) && $flow->timed) {
                return true;
            }
        }
        return false;
    }

    public function getCurrentFlow()
    {
        return $this->flow_list[0];
    }

    public function isFlowExist(): bool
    {
        return isset($this->flow_list[0]) && $this->flow_list[0];
    }
}
