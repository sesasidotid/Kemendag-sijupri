<?php

use App\Http\Controllers\TestNotificationController;
use Eyegil\Base\Commons\Rest\RESTor;

RESTor::createRest(TestNotificationController::class)
    ->build();
