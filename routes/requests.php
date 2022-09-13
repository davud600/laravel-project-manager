<?php

use App\Http\Controllers\RequestController;
use App\Permissions\Permission;
use Illuminate\Support\Facades\Route;

Route::controller(RequestController::class)->group(function () {
    Route::middleware('can:' . Permission::LIST_REQUESTS)->group(function () {
        Route::get('/requests', 'index');
        Route::get('/requests/{request}', 'show');
    });

    Route::middleware('can:' . Permission::CREATE_REQUESTS)->group(function () {
        Route::get('/requests/create', 'create');
        Route::post('/requests/create', 'store');
    });

    Route::middleware('can:' . Permission::EDIT_REQUESTS)->group(function () {
        Route::get('/requests/{request}/edit', 'edit');
        Route::put('/requests/{request}', 'update');
    });

    Route::middleware('can:' . Permission::DELETE_REQUESTS)->group(function () {
        Route::delete('/requests/{request}', 'destroy');
    });

    Route::middleware('can:' . Permission::CHANGE_STATUS_REQUESTS)->group(function () {
        Route::get('/requests/{request}/change-status', 'changeStatus');
    });
});
