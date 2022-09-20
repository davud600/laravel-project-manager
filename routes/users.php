<?php

use App\Http\Controllers\UserController;
use App\Permissions\Permission;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('users')
    ->group(function () {
        Route::middleware('can:' . Permission::CREATE_USERS)->group(function () {
            Route::get('/create', 'create');
            Route::post('/create', 'store');
        });

        Route::middleware('can:' . Permission::EDIT_USERS)->group(function () {
            Route::get('/{user}/edit', 'edit');
            Route::put('/{user}', 'update');
        });

        Route::middleware('can:' . Permission::DELETE_USERS)->group(function () {
            Route::delete('/{user}', 'destroy');
        });

        Route::middleware('can:' . Permission::LIST_USERS)->group(function () {
            Route::get('', 'index')
                ->name('users');
            Route::get('/{user}', 'show');
        });
    });
