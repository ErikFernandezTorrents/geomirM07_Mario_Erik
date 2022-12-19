<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('files', FileController::class);

Route::post('/register', [TokenController::class,'register']);//->middleware('guest');

Route::post('/login', [TokenController::class,'login']);

Route::post('/logout', [TokenController::class,'logout'])->middleware('auth:sanctum');

Route::get('/user', [TokenController::class,'user'])->middleware('auth:sanctum');

Route::apiResource('/places', PlaceController::class);

Route::post('/store', [PlaceController::class,'store'])->middleware('auth:sanctum');
Route::post('/list', [PlaceController::class,'list'])->middleware('auth:sanctum');
