<?php

use App\Http\Controllers\UserController;
use App\Permissions\Permission;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::middleware('can:' . Permission::CREATE_USERS)->group(function () {
        Route::get('/users/create', 'create');
        Route::post('/users/create', 'store');
    });

    Route::middleware('can:' . Permission::EDIT_USERS)->group(function () {
        Route::get('/users/{user}/edit', 'edit');
        Route::put('/users/{user}', 'update');
    });

    Route::middleware('can:' . Permission::DELETE_USERS)->group(function () {
        Route::delete('/users/{user}', 'destroy');
    });

    Route::middleware('can:' . Permission::LIST_USERS)->group(function () {
        Route::get('/users', 'index')
            ->name('users');
        Route::get('/users/{user}', 'show');
    });
});
