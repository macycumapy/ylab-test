<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/auth', [AuthController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => '/task'], function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::get('/{id}', [TaskController::class, 'show']);
        Route::put('/{id}', [TaskController::class, 'update']);
        Route::delete('/{id}', [TaskController::class, 'destroy']);

        Route::post('/{id}/confirm', [TaskController::class, 'confirm'])->middleware('role:admin');
        Route::post('/report', [TaskController::class, 'getReport'])->middleware('role:admin');
    });
});
