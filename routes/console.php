<?php

use Eyegil\NotificationDriverDb\Services\NotificationMessageService;
use Eyegil\SijupriUkom\Services\ExamGradeService;
use Eyegil\SijupriUkom\Services\ExamScheduleService;
use Eyegil\SijupriUkom\Services\RoomUkomService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

// NOTIFICATION TERMINATOR
Schedule::call(function (NotificationMessageService $notificationMessageService) {
    Log::info("Start Notification Daily Cleanup");
    $deletedRows = $notificationMessageService->deleteExpired();
    Log::info("Finished Notification Daily Cleanup: Deleted " . $deletedRows['deletedForUsers'] . " user notifications and " . $deletedRows['deletedForTopics'] . " topic notifications.");
})->daily();

//PARTICIPANT UKOM ENTER ROOM
Schedule::call(function (RoomUkomService $roomUkomService, ExamGradeService $examGradeService, ExamScheduleService $examScheduleService) {
    $startTime = microtime(true);

    try {
        Log::info("Start Room Selection Participant");
        $roomUkomService->registeringRoom();
        Log::info("Finished Room Selection Participant");
    } catch (\Throwable $th) {
    }

    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;
    Log::info("Total Execution Room Selection Participant Time: " . $executionTime . " seconds");

    //-----------------------------
    $startTime = microtime(true);

    try {
        Log::info("Start Grade Exam");
        $examGradeService->gradeExam();
        Log::info("Finished Grade Exam");
    } catch (\Throwable $th) {
    }

    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;
    Log::info("Total Execution Grade Exam Time: " . $executionTime . " seconds");

    //-----------------------------
    $startTime = microtime(true);

    try {
        Log::info("Start Schedule Selection Examiner");
        $examScheduleService->generateSchedule();
        Log::info("Finished Schedule Selection Examiner");
    } catch (\Throwable $th) {
    }

    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;
    Log::info("Total Execution Schedule Selection Examiner Time: " . $executionTime . " seconds");
})->everyMinute();

// BACKUP DATA -------------
Schedule::call(function () {
    if (config('eyegil.backup.enable', null) == "true") {
        Log::info("Start Backup Data");

        $backupDir = storage_path('app/backups');
        $backupTime = now()->format('Y-m-d_H-i-s');
        $zipPath = config('eyegil.backup.path', "/home") . "/backup_{$backupTime}.zip";

        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $dbName = config('database.connections.pgsql.database');
        $dbUser = config('database.connections.pgsql.username');
        $dbPass = config('database.connections.pgsql.password');
        $dbHost = config('database.connections.pgsql.host', '127.0.0.1');
        $dbPort = config('database.connections.pgsql.port', '5432');

        $sqlFile = "{$backupDir}/database_{$backupTime}.sql";

        $command = "PGPASSWORD=\"{$dbPass}\" pg_dump -h {$dbHost} -p {$dbPort} -U {$dbUser} -F p -d {$dbName} > {$sqlFile}";
        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            throw new \Exception("Database backup failed.");
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {

            $storagePath = storage_path('app');
            $files = File::allFiles($storagePath);
            foreach ($files as $file) {
                $relativePath = ltrim(str_replace($storagePath, '', $file->getRealPath()), '/\\');
                $zip->addFile($file->getRealPath(), "storage/app/{$relativePath}");
            }

            $zip->addFile($sqlFile, "database.sql");

            $zip->close();
        } else {
            throw new \Exception("Could not create ZIP archive.");
        }

        File::delete($sqlFile);
        Log::info("Finish Backup Data");
    }
})->weeklyOn(6, '05:00');
