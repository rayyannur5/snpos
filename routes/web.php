<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserRoles\LevelController;
use App\Http\Controllers\UserRoles\ModuleController;
use App\Http\Controllers\UserRoles\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware('auth')->group(function () {
    //   DASHBOARD
    Route::get('/', [DashboardController::class, 'index']);
    Route::post('/changePassword', [LoginController::class, 'changePassword']);


    // USER & ROLES
    Route::controller(UserController::class)->prefix('/user&roles/users')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
        Route::post('/reset/{id}', 'reset');
        Route::post('/active/{id}', 'setActive');
    });

    Route::controller(LevelController::class)->prefix('/user&roles/levels')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
    });

    Route::controller(ModuleController::class)->prefix('/user&roles/modules')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
    });

});
