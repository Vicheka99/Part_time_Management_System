<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/login',[AuthenticationController::class,'loginForm'])->name('login');
Route::post('/login',[AuthenticationController::class,'login'])->name('loginSubmit');
Route::post('/login',[AuthenticationController::class,'login'])->name('loginSubmit');


Route::middleware(['auth'])->group(function(){
    Route::post('/logout',[AuthenticationController::class,'logout'])->name('logout');

    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::post('/upload-file', 'uploadFile')->name('uploadFile');
        Route::get('/migrate', 'migrate');
    });
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/create', 'create')->name('create.user');
        Route::post('/user/create', 'store')->name('store.user');
        Route::get('/user/index', 'index')->name('index.user');
        Route::get('/user/update/{id}', 'edit')->name('edit.user');
        Route::put('/user/update/{id}', 'update')->name('update.user');
        Route::delete('/user/delete', 'destroy')->name('delete.user');
    });

    Route::controller(CourseController::class)->group(function(){
        Route::get('/course/create', 'create')->name('create.course');
        Route::post('/course/create', 'store')->name('store.course');
        Route::get('/course/index', 'index')->name('index.course');
        Route::get('/course/update/{id}', 'edit')->name('edit.course');
        Route::put('/course/update/{id}', 'update')->name('update.course');
        Route::delete('/course/delete', 'destroy')->name('delete.course');
    });

    Route::controller(StudentController::class)->group(function(){
        Route::get('/student/create', 'create')->name('create.student');
        Route::post('/student/create', 'store')->name('store.student');
        Route::get('/student/index', 'index')->name('index.student');
        Route::get('/student/update/{id}', 'edit')->name('edit.student');
        Route::put('/student/update/{id}', 'update')->name('update.student');
        Route::delete('/student/delete', 'destroy')->name('delete.student');
    });

});
