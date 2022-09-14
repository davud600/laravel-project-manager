<?php

use App\Http\Controllers\MessageController;
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

Route::get('/', fn () => view('welcome'));
Route::get('/profile', fn () => view('user.profile'))
    ->name('profile');

Route::get('/dashboard', [UserController::class, 'dashboard'])
    ->name('dashboard');

Route::get('/download-file', [MessageController::class, 'downloadFile']);

Route::post('/requests/{request_id}/create-message', [MessageController::class, 'store'])
    ->name('create-message');

include __DIR__ . '/auth.php';
include __DIR__ . '/requests.php';
include __DIR__ . '/projects.php';
include __DIR__ . '/users.php';
