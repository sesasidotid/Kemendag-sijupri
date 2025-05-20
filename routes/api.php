<?php

use App\Http\Controllers\DashboardController;
use Eyegil\Base\Commons\Rest\RESTor;


RESTor::createRest(DashboardController::class)
    ->build();
