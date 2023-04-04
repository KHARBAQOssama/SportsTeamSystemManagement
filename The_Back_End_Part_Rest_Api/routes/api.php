<?php

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\TournamentController;

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


Route::get('sport/community',[SportController::class,'authenticatedSportUsers']);
Route::get('sport/users',[SportController::class,'getSportUsers']);
Route::apiResource('sport',SportController::class);


Route::post('team/search',[TeamController::class,'getBySearch']);
Route::apiResource('team',TeamController::class);


Route::get('tournament/{id}/standing',[TournamentController::class,'tournamentStandings']);
Route::apiResource('tournament',TournamentController::class);

Route::get('games-in-sport',[GameController::class,'getGamesInSport']);
Route::get('games/next',[GameController::class,'nextGame']);
Route::post('image',[PhotoController::class,'store']);
Route::get('images',[PhotoController::class,'get']);
Route::apiResource('game',GameController::class);



