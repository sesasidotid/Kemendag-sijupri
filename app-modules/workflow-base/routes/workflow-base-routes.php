<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\WorkflowBase\Http\Controllers\ObjectTaskController;
use Eyegil\WorkflowBase\Http\Controllers\PendingTaskController;
use Illuminate\Support\Facades\Route;

RESTor::createRest(PendingTaskController::class)
    ->createRest(ObjectTaskController::class)
    ->build();
