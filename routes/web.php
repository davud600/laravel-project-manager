<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Permissions\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profile', function () {
    return view('user.profile');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/dashboard', 'dashboard');
});


/* User routes  */
Route::controller(UserController::class)->group(function () {
    Route::middleware('can:' . Permission::LIST_USERS)->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show')
            ->where('id', '[0-9]+');
    });

    Route::middleware('can:' . Permission::CREATE_USERS)->group(function () {
        Route::get('/users/create', 'create');
        Route::post('/users/create', 'store');
    });

    Route::middleware('can:' . Permission::EDIT_USERS)->group(function () {
        Route::get('/users/{id}/edit', 'edit')
            ->where('id', '[0-9]+');
        Route::put('/users/{id}', 'update')
            ->where('id', '[0-9]+');
    });

    Route::middleware('can:' . Permission::DELETE_USERS)->group(function () {
        Route::delete('/users/{id}', 'destroy')
            ->where('id', '[0-9]+');
    });
});


/* Project routes  */
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


/* Request routes  */
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

Route::post('requests/{request_id}/create-message', [MessageController::class, 'store']);

include __DIR__ . '/auth.php';
