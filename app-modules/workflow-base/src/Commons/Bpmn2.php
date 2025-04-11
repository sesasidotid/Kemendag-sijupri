<?php

namespace Eyegil\WorkflowBase\Commons;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Log;

class Bpmn2
{
    private $namespace = 'http://www.omg.org/spec/BPMN/20100524/MODEL'; // BPMN XML namespace

    function parseBpmnXml($xmlFile)
    {
        Log::info("xmlFile =" . $xmlFile);
        $dom = new DOMDocument;
        $dom->load($xmlFile);
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('bpmn', $this->namespace);

        $workflow = [
            'process' => [],
            'elements' => []
        ];

        // Get processes
        $processes = $xpath->query('//bpmn:process');
        foreach ($processes as $process) {
            $workflow['process']['id'] = $process->getAttribute('id');
            $workflow['process']['name'] = $process->getAttribute('name');

            // Get start events
            $startEvents = $xpath->query('.//bpmn:startEvent', $process);
            foreach ($startEvents as $startEvent) {
                $workflow['elements']['startEvents'][] = [
                    'id' => $startEvent->getAttribute('id'),
                    'name' => $startEvent->getAttribute('name'),
                    'outgoings' => $this->extractOutgoing($startEvent)
                ];
            }

            // Get end events
            $endEvents = $xpath->query('.//bpmn:endEvent', $process);
            foreach ($endEvents as $endEvent) {
                $workflow['elements']['endEvents'][] = [
                    'id' => $endEvent->getAttribute('id'),
                    'name' => $endEvent->getAttribute('name'),
                    'incomings' => $this->extractIncoming($endEvent)
                ];
            }

            // Get user tasks
            $userTasks = $xpath->query('.//bpmn:userTask', $process);
            foreach ($userTasks as $userTask) {
                $workflow['elements']['userTasks'][] = [
                    'id' => $userTask->getAttribute('id'),
                    'name' => $userTask->getAttribute('name'),
                    'outgoings' => $this->extractOutgoing($userTask),
                    'incomings' => $this->extractIncoming($userTask),
                    'assignment' => [
                        'user' => $userTask->getAttribute('assignment') // Example of user assignment
                    ]
                ];
            }

            // Get gateways
            $gateways = $xpath->query('.//bpmn:gateway', $process);
            foreach ($gateways as $gateway) {
                $workflow['elements']['gateways'][] = [
                    'id' => $gateway->getAttribute('id'),
                    'name' => $gateway->getAttribute('name'),
                    'gatewayType' => $gateway->getAttribute('gatewayDirection') // can use this for gateway types
                ];
            }

            // Get gateways
            $exclusiveGateways = $xpath->query('.//bpmn:exclusiveGateway', $process);
            foreach ($exclusiveGateways as $exclusiveGateway) {
                $workflow['elements']['exclusiveGateway'][] = [
                    'id' => $exclusiveGateway->getAttribute('id'),
                    'name' => $exclusiveGateway->getAttribute('name'),
                    'outgoings' => $this->extractOutgoing($exclusiveGateway),
                    'incomings' => $this->extractIncoming($exclusiveGateway)
                ];
            }

            // Get sequence flows
            $sequenceFlows = $xpath->query('.//bpmn:sequenceFlow', $process);
            foreach ($sequenceFlows as $sequenceFlow) {
                $workflow['elements']['sequenceFlows'][] = [
                    'id' => $sequenceFlow->getAttribute('id'),
                    'source' => $sequenceFlow->getAttribute('sourceRef'),
                    'target' => $sequenceFlow->getAttribute('targetRef'),
                    'condition' => $this->extractCondition($sequenceFlow), // Extract conditions if any
                ];
            }
        }

        return $workflow;
    }

    function extractIncoming($element)
    {
        $incoming = $element->getElementsByTagNameNS($this->namespace, 'incoming');
        
        $incomings = [];
        if ($incoming->length > 0) {
            for ($i=0; $i < $incoming->length ; $i++) { 
                $incomings[] = $incoming->item($i)->textContent;
            }
        }
        return $incomings;
    }

    function extractOutgoing($element)
    {
        $outgoing = $element->getElementsByTagNameNS($this->namespace, 'outgoing');
        
        $outgoings = [];
        if ($outgoing->length > 0) {
            for ($i=0; $i < $outgoing->length ; $i++) { 
                $outgoings[] = $outgoing->item($i)->textContent;
            }
        }
        return $outgoings;
    }

    function extractCondition($sequenceFlow)
    {
        $conditionExpression = $sequenceFlow->getElementsByTagNameNS($this->namespace, 'conditionExpression');

        if ($conditionExpression->length > 0) {
            $condition = $conditionExpression->item(0);
            return [
                'expression' => $condition->textContent
            ];
        }
        return null;
    }
}
