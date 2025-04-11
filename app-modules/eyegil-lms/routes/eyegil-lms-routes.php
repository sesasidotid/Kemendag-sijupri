<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\EyegilLms\Http\Controllers\QuestionController;
use Eyegil\EyegilLms\Http\Controllers\AnswerController;

RESTor::createRest(QuestionController::class)
    ->createRest(AnswerController::class)
    ->build();
