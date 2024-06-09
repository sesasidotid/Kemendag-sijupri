<?php

use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/security/user', [UserController::class, "indexAdminSijupri"])
    ->name('/security/user');

Route::get('/security/user/detail/{nip}', [UserController::class, "detailAdminSijupri"])
    ->name('/security/user/detail');

Route::post('/security/user/edit/{nip}', [UserController::class, "editAdminSijupri"])
    ->name('/security/user/edit')
    ->defaults('object', 'Admin SIjuPRI');

Route::get('/security/role', [RoleController::class, "index"])
    ->name('/security/role');

Route::get('/security/role/detail/{code}', [RoleController::class, "detail"])
    ->name('/security/role/detail');

Route::put('/security/role/edit/{code}', [RoleController::class, "edit"])
    ->name('/security/role/edit')
    ->defaults('object', 'Admin SIjuPRI');
