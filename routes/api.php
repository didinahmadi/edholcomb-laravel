<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\TeamController;
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

Route::post('login', [AuthController::class, 'login']);

Route::group(['namespace' => 'API', 'middleware' => 'auth:api'], function ($router) {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

    Route::prefix('team')->group(function () {
        Route::get('/', [TeamController::class, 'index']);
        Route::post('/', [TeamController::class, 'store']);
        Route::put('{id}', [TeamController::class, 'update']);
        Route::delete('{id}', [TeamController::class, 'destroy']);
    });

    Route::prefix('player')->group(function () {
        Route::post('/', [PlayerController::class, 'store']);
        Route::get('/', [PlayerController::class, 'index']);
        Route::put('{id}', [PlayerController::class, 'update']);
    });
});
