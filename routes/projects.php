<?php

use App\Http\Controllers\ProjectController;
use App\Permissions\Permission;
use Illuminate\Support\Facades\Route;

Route::controller(ProjectController::class)->prefix('projects')
    ->group(function () {
        Route::middleware('can:' . Permission::CREATE_PROJECTS)->group(function () {
            Route::get('/create', 'create');
            Route::post('/create', 'store');
        });

        Route::middleware('can:' . Permission::EDIT_PROJECTS)->group(function () {
            Route::get('/{project}/edit', 'edit');
            Route::put('/{project}', 'update');
        });

        Route::middleware('can:' . Permission::DELETE_PROJECTS)->group(function () {
            Route::delete('/{project}', 'destroy');
        });

        Route::middleware('can:' . Permission::ADD_TIME_TO_PROJECTS)->group(function () {
            Route::post('/{project}/change-estimated-time', 'addEstimatedTime');
        });

        Route::middleware('can:' . Permission::LIST_PROJECTS)->group(function () {
            Route::get('', 'index');
            Route::get('/{project}', 'show');
        });
    });
