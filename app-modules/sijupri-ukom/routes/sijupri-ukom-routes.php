<?php

use Eyegil\Base\Commons\Rest\RESTor;
use Eyegil\SijupriUkom\Http\Controllers\DocumentUkomController;
use Eyegil\SijupriUkom\Http\Controllers\ExaminerUkomController;
use Eyegil\SijupriUkom\Http\Controllers\ExamScheduleController;
use Eyegil\SijupriUkom\Http\Controllers\ExamTypeController;
use Eyegil\SijupriUkom\Http\Controllers\ParticipantUkomController;
use Eyegil\SijupriUkom\Http\Controllers\ParticipantUkomTaskController;
use Eyegil\SijupriUkom\Http\Controllers\RoomUkomController;
use Eyegil\SijupriUkom\Http\Controllers\ExamController;
use Eyegil\SijupriUkom\Http\Controllers\ExamGradeController;
use Eyegil\SijupriUkom\Http\Controllers\ParticipantUkomDetailController;
use Eyegil\SijupriUkom\Http\Controllers\UkomBanController;
use Eyegil\SijupriUkom\Http\Controllers\UkomModuleController;
use Eyegil\SijupriUkom\Http\Controllers\UkomFormulaController;
use Eyegil\SijupriUkom\Http\Controllers\UkomGradeController;

RESTor::createRest(ExaminerUkomController::class)
    ->createRest(DocumentUkomController::class)
    ->createRest(ParticipantUkomTaskController::class)
    ->createRest(ParticipantUkomController::class)
    ->createRest(RoomUkomController::class)
    ->createRest(ExamTypeController::class)
    ->createRest(UkomModuleController::class)
    ->createRest(ExamScheduleController::class)
    ->createRest(ExamController::class)
    ->createRest(ExamGradeController::class)
    ->createRest(UkomFormulaController::class)
    ->createRest(UkomBanController::class)
    ->createRest(UkomGradeController::class)
    ->createRest(ParticipantUkomDetailController::class)
    ->build();
