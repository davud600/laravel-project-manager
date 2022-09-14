<?php

use App\Http\Controllers\ProjectController;
use App\Permissions\Permission;
use Illuminate\Support\Facades\Route;

Route::controller(ProjectController::class)->group(function () {
    Route::middleware('can:' . Permission::CREATE_PROJECTS)->group(function () {
        Route::get('/projects/create', 'create');
        Route::post('/projects/create', 'store');
    });

    Route::middleware('can:' . Permission::EDIT_PROJECTS)->group(function () {
        Route::get('/projects/{project}/edit', 'edit');
        Route::put('/projects/{project}', 'update');
    });

    Route::middleware('can:' . Permission::DELETE_PROJECTS)->group(function () {
        Route::delete('/projects/{project}', 'destroy');
    });

    Route::middleware('can:' . Permission::ADD_TIME_TO_PROJECTS)->group(function () {
        Route::post('/projects/{project}/change-estimated-time', 'addEstimatedTime');
    });

    Route::middleware('can:' . Permission::LIST_PROJECTS)->group(function () {
        Route::get('/projects', 'index');
        Route::get('/projects/{project}', 'show');
    });
});
