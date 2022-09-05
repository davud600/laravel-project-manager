<?php

use App\Http\Controllers\ProjectController;
use App\Permissions\Permission;
use Illuminate\Support\Facades\Route;

Route::controller(ProjectController::class)->group(function () {
    Route::middleware('can:' . Permission::LIST_PROJECTS)->group(function () {
        Route::get('/projects', 'index');
        Route::get('/projects/{id}', 'show')
            ->where('id', '[0-9]+');
    });

    Route::middleware('can:' . Permission::CREATE_PROJECTS)->group(function () {
        Route::get('/projects/create', 'create');
        Route::post('/projects/create', 'store');
    });

    Route::middleware('can:' . Permission::EDIT_PROJECTS)->group(function () {
        Route::get('/projects/{id}/edit', 'edit')
            ->where('id', '[0-9]+');
        Route::put('/projects/{id}', 'update')
            ->where('id', '[0-9]+');
    });

    Route::middleware('can:' . Permission::DELETE_PROJECTS)->group(function () {
        Route::delete('/projects/{id}', 'destroy')
            ->where('id', '[0-9]+');
    });

    Route::middleware('can:' . Permission::ADD_TIME_TO_PROJECTS)->group(function () {
        Route::post('/projects/{id}/change-estimated-time', 'addEstimatedTime')
            ->where('id', '[0-9]+');
    });
});
