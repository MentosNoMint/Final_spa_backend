<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register' , [\App\Http\Controllers\usersController::class , 'register']);
Route::post('/login' , [\App\Http\Controllers\usersController::class , 'login']);
Route::get('/airport' , [\App\Http\Controllers\searchController::class , 'airports']);
Route::get('/flight' , [\App\Http\Controllers\flightController::class , 'search']);
Route::post('/booking' , [\App\Http\Controllers\bookingController::class , 'booking']);
Route::get('/booking/{code}' , [\App\Http\Controllers\bookingController::class , 'bookingInfo']);
Route::middleware('auth:api')->get('/user' , [\App\Http\Controllers\profileController::class , 'infoUser']);
Route::middleware('auth:api')->get('/user/booking' , [\App\Http\Controllers\profileController::class , 'infoUser']);

