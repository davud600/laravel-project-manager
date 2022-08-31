<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store']);
// ->middleware('guest');

Route::get('/register', [RegisteredUserController::class, 'create']);
// ->middleware('guest')
// ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create']);
// ->middleware('guest')
// ->name('login');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);
    // ->middleware('auth')
    // ->name('logout');
