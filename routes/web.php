<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'dashboard');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/users/create', 'create');
    Route::post('/users/create', 'store');
    Route::get('/users/{id}', 'show');
    Route::get('/users/{id}/edit', 'edit');
    Route::put('/users/{id}', 'update');
    Route::delete('/users/{id}', 'destroy');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('/projects/create', 'create');
    Route::post('/projects/create', 'store');
    Route::get('/projects/{id}', 'show');
    Route::get('/projects/{id}/edit', 'edit');
    Route::put('/projects/{id}', 'update');
    Route::delete('/projects/{id}', 'destroy');
    Route::post('/projects/{id}/change-estimated-time', 'addEstimatedTime');
});

Route::controller(RequestController::class)->group(function () {
    Route::get('/requests/create', 'create');
    Route::post('/requests/create', 'store');
    Route::get('/requests/{id}', 'show');
    Route::get('/requests/{id}/edit', 'edit');
    Route::put('/requests/{id}', 'update');
    Route::delete('/requests/{id}', 'destroy');
    Route::get('/requests/{id}/change-status', 'changeStatus');
});

Route::post('requests/{request_id}/create-message', [MessageController::class, 'store']);

include __DIR__ . '/auth.php';
