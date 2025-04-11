<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\SecurityPassword\Http\Controllers\PasswordController;

RESTor::createRest(PasswordController::class)->build();
