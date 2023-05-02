<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\ReservationController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::group([
    'middleware' => 'api',
    'prefix' =>'password'
],function(){
    Route::post('reset-password',[AuthController::class , 'resetPassword']);
    Route::post('reset',[AuthController::class , 'reset']);
});

Route::put('user/updateImage',[UserController::class,'updateSelfImage']);
Route::put('user/update',[UserController::class,'updateSelf']);
Route::post('users/add',[UserController::class,'storeByAdmin']);
Route::apiResource('user',UserController::class);

Route::apiResource('branch',BranchController::class);
Route::apiResource('sport',SportController::class);

Route::post('team/search',[TeamController::class,'getBySearch']);
Route::apiResource('team',TeamController::class);


Route::get('tournament/{tournament}/standing',[TournamentController::class,'tournamentStandings']);
Route::apiResource('tournament',TournamentController::class);

Route::get('game/next',[GameController::class,'nextGame']);
Route::apiResource('game',GameController::class);

Route::apiResource('blog',BlogController::class);
Route::apiResource('comment',CommentController::class);
Route::apiResource('reservation',ReservationController::class);
Route::apiResource('product',ProductController::class);
Route::apiResource('cart',CartController::class);
Route::get('permission',[PermissionController::class,'index']);
Route::get('role',[RoleController::class,'index']);
Route::post('assign/permission/{user}',[PermissionController::class,'assign']);

