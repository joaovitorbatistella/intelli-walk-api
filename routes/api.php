<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\EventController;
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
/**Route for login API */


//get token
Route::post('token', [AuthController::class, 'auth']);
Route::post('createuser', [UserController::class, 'store']);

/**Midlleware for Auth Routes */
Route::middleware('auth:api')->group(function(){
    Route::post('handle-event', [EventController::class, 'handleEvent']);
});

