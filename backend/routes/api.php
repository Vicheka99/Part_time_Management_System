<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\UserController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/hello', function() {
    return 'Hello, API!';
});

Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);

Route::middleware('jwt.verify')->group(function() {

    Route::controller(CourseController::class)->group(function (){
        Route::prefix('course')->group(function () {
            Route::get('/','index');
        });
    });
    Route::controller(UserController::class)->group(function (){
        Route::prefix('user')->group(function () {
            Route::get('/','index');
        });
    });

});

