<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TodoController;
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

// API Default
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [AuthenticationController::class,'register']);
Route::post('login', [AuthenticationController::class, 'login']);

Route::get('/user',[AuthenticationController::class, 'getUser'])->middleware('jwt.verify');
Route::get('logout', [AuthenticationController::class, 'logout'])->middleware('jwt.verify');

Route::group(['prefix' => 'todo', 'middleware' => 'jwt.verify'], function () {

    Route::get('/getall', [TodoController::class, 'index']);
    Route::post('/store', [TodoController::class, 'store']);
    Route::get('/show/{slug}', [TodoController::class, 'show']);
    Route::get('/edit/{slug}', [TodoController::class, 'edit']);
    Route::put('/update/{id}', [TodoController::class, 'update']);
    Route::delete('/delete/{id}', [TodoController::class, 'destroy']);

});
Route::group(['prefix' => 'profile', 'middleware' => 'jwt.verify'], function () {

    Route::post('/upload-photo/{id}',[ProfileController::class, 'uploadPhoto']);
    Route::post('/change-password',[ProfileController::class, 'changePassword']);

    Route::get('/edit/{id}',[ProfileController::class, 'edit']);
    Route::put('/update/{id}',[ProfileController::class, 'update']);

});
