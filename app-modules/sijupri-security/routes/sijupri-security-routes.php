<?php

use Eyegil\SijupriSecurity\Http\Controllers\SijupriAuthController;
use Illuminate\Support\Facades\Route;
// use Eyegil\SijupriSecurity\Http\Controllers\SijupriSecurityController;

// Route::get('/sijupri-securities', [SijupriSecurityController::class, 'index'])->name('sijupri-securities.index');
// Route::get('/sijupri-securities/create', [SijupriSecurityController::class, 'create'])->name('sijupri-securities.create');
// Route::post('/sijupri-securities', [SijupriSecurityController::class, 'store'])->name('sijupri-securities.store');
// Route::get('/sijupri-securities/{sijupri-security}', [SijupriSecurityController::class, 'show'])->name('sijupri-securities.show');
// Route::get('/sijupri-securities/{sijupri-security}/edit', [SijupriSecurityController::class, 'edit'])->name('sijupri-securities.edit');
// Route::put('/sijupri-securities/{sijupri-security}', [SijupriSecurityController::class, 'update'])->name('sijupri-securities.update');
// Route::delete('/sijupri-securities/{sijupri-security}', [SijupriSecurityController::class, 'destroy'])->name('sijupri-securities.destroy');

Route::get('/login', [SijupriAuthController::class, 'view_login'])
    ->name('login');
Route::post('/login', [SijupriAuthController::class, 'post_authenticate'])
    ->middleware(['throttle:10,1'])
    ->name('do_login');
