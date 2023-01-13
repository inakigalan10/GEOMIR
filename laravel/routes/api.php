<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PlaceController;




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
Route::get('user', [TokenController::class, 'user'])->middleware(['auth:sanctum']);

Route::post('logout', [TokenController::class, 'logout'])->middleware(['auth:sanctum']);

Route::post('login', [TokenController::class, 'login']);

Route::post('register', [TokenController::class, 'register']);

Route::apiResource('post', PostController::class);
Route::post('/posts/{post}/like', [PostController::class, 'like']);
Route::delete('/posts/{post}/like', [PostController::class, 'unlike']);

Route::apiResource('place', PlaceController::class);
Route::post('/places/{place}/favorite', [PlaceController::class, 'favorite']);
Route::delete('/places/{place}/favorite', [PlaceController::class, 'unfavorite']);

Route::apiResource('files', FileController::class);

 