<?php

use App\Http\Controllers\ExcelDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ExcelDataController::class)->group(function () {
    Route::get('/import-users', 'importUsers');
    Route::get('/import-projects', 'importProjects');
    Route::get('/import-employee-activity', 'importEmployeeActivity');
});
