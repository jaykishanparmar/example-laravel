<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [UserController::class, 'login']);
Route::post('/registration', [UserController::class, 'registration']);

Route::group(['middleware' => ['auth:api']], function () {
    
    Route::controller(TaskController::class)->prefix('task')->group(function () {
        Route::get('/', 'getTask');
        Route::post('/', 'addTask');
    });
});