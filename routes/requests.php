<?php

use App\Http\Controllers\RequestController;
use App\Permissions\Permission;
use Illuminate\Support\Facades\Route;

Route::controller(RequestController::class)->prefix('requests')
    ->group(function () {
        Route::middleware('can:' . Permission::CREATE_REQUESTS)->group(function () {
            Route::get('/create', 'create');
            Route::post('/create', 'store');
        });

        Route::middleware('can:' . Permission::EDIT_REQUESTS)->group(function () {
            Route::get('/{request}/edit', 'edit');
            Route::put('/{request}', 'update');
        });

        Route::middleware('can:' . Permission::DELETE_REQUESTS)->group(function () {
            Route::delete('/{request}', 'destroy');
        });

        Route::middleware('can:' . Permission::CHANGE_STATUS_REQUESTS)->group(function () {
            Route::get('/{request}/change-status', 'changeStatus');
        });

        Route::middleware('can:' . Permission::LIST_REQUESTS)->group(function () {
            Route::get('', 'index');
            Route::get('/{request}', 'show');
        });
    });
