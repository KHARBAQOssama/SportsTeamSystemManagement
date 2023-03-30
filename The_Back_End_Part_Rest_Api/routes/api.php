<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::post('user/{user}/deleteImage',[UserController::class,'deleteUserImage']);
Route::post('user/{user}/updateImage',[UserController::class,'updateUserImage']);
Route::post('user/search',[UserController::class,'getBySearch']);
Route::post('users/add',[UserController::class,'storeByAdmin']);
Route::apiResource('user',UserController::class);
