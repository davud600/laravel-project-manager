<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pages;
use App\Http\Controllers\ProjectController;
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

Route::controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'dashboard');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/users/create', 'create');
    Route::post('/users/create', 'store');
    Route::get('/users/{product}', 'show');
    Route::get('/users/{product}/edit', 'edit');
    Route::put('/users/{product}', 'update');
    Route::delete('/users/{product}', 'destroy');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('/projects', 'index');
    Route::get('/projects/create', 'create');
    Route::post('/projects/create', 'store');
    Route::get('/projects/{product}', 'show');
    Route::get('/projects/{product}/edit', 'edit');
    Route::put('/projects/{product}', 'update');
    Route::delete('/projects/{product}', 'destroy');
});
