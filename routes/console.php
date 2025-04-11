<?php

use Eyegil\NotificationDriverDb\Services\NotificationMessageService;
use Eyegil\SijupriUkom\Services\ExamGradeService;
use Eyegil\SijupriUkom\Services\RoomUkomService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

// NOTIFICATION TERMINATOR
Schedule::call(function (NotificationMessageService $notificationMessageService) {
    Log::info("Start Notification Daily Cleanup");
    $deletedRows = $notificationMessageService->deleteExpired();
    Log::info("Finished Notification Daily Cleanup: Deleted " . $deletedRows['deletedForUsers'] . " user notifications and " . $deletedRows['deletedForTopics'] . " topic notifications.");
})->daily();

//PARTICIPANT UKOM ENTER ROOM
Schedule::call(function (RoomUkomService $roomUkomService) {
    Log::info("Start Room Selection Participant");
    $roomUkomService->registeringRoom();
    Log::info("Finished Room Selection Participant");
})->everyMinute();

//GRADE EXAM
Schedule::call(function (ExamGradeService $examGradeService) {
    Log::info("Start Grade Exam");
    $examGradeService->gradeExam();
    Log::info("Finished Grade Exam");
})->everyMinute();
