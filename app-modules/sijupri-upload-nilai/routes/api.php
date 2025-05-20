<?php

use Illuminate\Support\Facades\Route;
use Src\Upload\Controller\UploadController;

Route::prefix('upload')->group(function () {
    Route::post('/pdf', [UploadController::class, 'upload']);
});
