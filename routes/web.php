<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Master\AreaController;
use App\Http\Controllers\Master\OutletController;
use App\Http\Controllers\Master\PaymentController;
use App\Http\Controllers\Master\ProductController;
use App\Http\Controllers\Master\ShiftController;
use App\Http\Controllers\Master\SmartNitroController;
use App\Http\Controllers\Schedule\ScheduleController;
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
    Route::controller(UserController::class)->prefix('/userroles/users')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
        Route::post('/reset/{id}', 'reset');
        Route::post('/active/{id}', 'setActive');
    });

    Route::controller(LevelController::class)->prefix('/userroles/levels')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
    });

    Route::controller(ModuleController::class)->prefix('/userroles/modules')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
    });


    // MASTER
    Route::controller(AreaController::class)->prefix('/master/area')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
    });

    Route::controller(OutletController::class)->prefix('/master/outlet')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
        Route::get('/{id}', 'show');
        Route::post('/{id}/addproduct', 'addProduct');
        Route::post('/{id}/updateproduct', 'updateProduct');
    });

    Route::controller(SmartNitroController::class)->prefix('/master/smartnitro')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
    });

    Route::controller(ShiftController::class)->prefix('/master/shift')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
    });

    Route::controller(ProductController::class)->prefix('/master/products')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
    });

    Route::controller(PaymentController::class)->prefix('/master/payments')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::post('/update', 'update');
    });

    // SCHEDULE
    Route::controller(ScheduleController::class)->prefix('/schedule')->group(function () {
        Route::get('/', 'index');
        Route::get('/getSchedule', 'getSchedule');
        Route::get('/create', 'create');
        Route::get('/createCanvasSchedule', 'createCanvasSchedule');
        Route::post('/update', 'update');
        Route::post('/importSchedule', 'importSchedule');
        Route::post('/saveSchedule', 'saveSchedule');
    });
});
