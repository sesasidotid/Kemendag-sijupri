<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\NotificationDriverDb\Http\Controllers\NotificationMessageController;

RESTor::createRest(NotificationMessageController::class)
    ->build();
