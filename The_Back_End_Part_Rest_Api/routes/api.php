<?php

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\GlobalSearchController;

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


Route::get('branch/community',[BranchController::class,'authenticatedBranchUsers']);
Route::get('branch/users',[BranchController::class,'getBranchUsers']);
Route::apiResource('branch',BranchController::class);


Route::apiResource('sport',SportController::class);


Route::post('team/search',[TeamController::class,'getBySearch']);
Route::apiResource('team',TeamController::class);


Route::get('tournament/{tournament}/standing',[TournamentController::class,'tournamentStandings']);
Route::apiResource('tournament',TournamentController::class);

Route::get('game/next',[GameController::class,'nextGame']);
Route::apiResource('game',GameController::class);

Route::get('blog/{blog}/comments',[BlogController::class,'getBlogComments']);
Route::apiResource('blog',BlogController::class);

Route::apiResource('comment',CommentController::class);

Route::apiResource('reservation',ReservationController::class);

Route::apiResource('product',ProductController::class);

Route::apiResource('cart',CartController::class);

Route::get('role',[RoleController::class,'index']);


Route::get('/search',[GlobalSearchController::class,'index']);