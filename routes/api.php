<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\BoardController;

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

Route::post('/login',  [AuthController::class, 'login']);
Route::post('/register',  [AuthController::class, 'register']);

Route::group(['middleware' =>  'auth:sanctum'], function (){
    Route::get('/user',  [UserController::class, 'getUser']);

    Route::get('/games/{game}',  [GameController::class, 'getGame']);
    Route::get('/games',  [GameController::class, 'getGames']);
    Route::get('/games/{game}/last-task',  [GameController::class, 'getLastTask']);
    Route::post('/games',  [GameController::class, 'store']);
    Route::post('/games/{game}/enroll',  [GameController::class, 'enroll']);

    Route::get('/boards/{board}',  [BoardController::class, 'getBoard']);
    Route::patch('/boards/{board}',  [BoardController::class, 'update']);
});
