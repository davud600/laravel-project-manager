<?php

use App\Http\Controllers\RequestController;
use App\Permissions\Permission;
use Illuminate\Support\Facades\Route;

Route::controller(RequestController::class)->group(function () {
    Route::middleware('can:' . Permission::LIST_REQUESTS)->group(function () {
        Route::get('/requests', 'index');
        Route::get('/requests/{id}', 'show')
            ->where('id', '[0-9]+');
    });

    Route::middleware('can:' . Permission::CREATE_REQUESTS)->group(function () {
        Route::get('/requests/create', 'create');
        Route::post('/requests/create', 'store');
    });

    Route::middleware('can:' . Permission::EDIT_REQUESTS)->group(function () {
        Route::get('/requests/{id}/edit', 'edit')
            ->where('id', '[0-9]+');
        Route::put('/requests/{id}', 'update')
            ->where('id', '[0-9]+');
    });

    Route::middleware('can:' . Permission::DELETE_REQUESTS)->group(function () {
        Route::delete('/requests/{id}', 'destroy')
            ->where('id', '[0-9]+');
    });

    Route::middleware('can:' . Permission::CHANGE_STATUS_REQUESTS)->group(function () {
        Route::get('/requests/{id}/change-status', 'changeStatus')
            ->where('id', '[0-9]+');
    });
});
