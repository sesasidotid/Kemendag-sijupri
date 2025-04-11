<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\SecurityBase\Http\Controllers\ApplicationController;
use Eyegil\SecurityBase\Http\Controllers\AuthenticationTypeController;
use Eyegil\SecurityBase\Http\Controllers\MenuController;
use Eyegil\SecurityBase\Http\Controllers\RoleController;
use Eyegil\SecurityBase\Http\Controllers\RoleTaskController;
use Eyegil\SecurityBase\Http\Controllers\UserController;
use Eyegil\SecurityBase\Http\Controllers\UserTaskController;

RESTor::createRest(ApplicationController::class)
    ->createRest(AuthenticationTypeController::class)
    ->createRest(MenuController::class)
    ->createRest(RoleTaskController::class)
    ->createRest(RoleController::class)
    ->createRest(UserTaskController::class)
    ->createRest(UserController::class)
    ->build();
