<?php

use App\Http\Controllers\api\ApiAttendanceController;
use App\Http\Controllers\api\ApiItemRequestController;
use App\Http\Controllers\api\ApiLeaveRequestController;
use App\Http\Controllers\api\ApiLoginController;
use App\Http\Controllers\api\ApiMaintenanceRequestController;
use App\Http\Controllers\api\ApiOvertimeController;
use App\Http\Controllers\api\ApiReportController;
use App\Http\Controllers\api\ApiScheduleController;
use App\Http\Controllers\api\ApiTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/tes', function () {return 'Tes';});

Route::post('/login', [ApiLoginController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

    // LOGIN
    Route::controller(ApiloginController::class)->group(function () {
        Route::get('/profile', 'profile');
        Route::post('/change_password', 'change_password');
        Route::post('/logout', 'logout');
    });

    // ATTENDANCE
    Route::controller(ApiAttendanceController::class)->prefix('/attendance')->group(function () {
        Route::get('/', 'attendance');
        Route::post('/', 'create');
        Route::post('/exit', 'exit');
        Route::get('/schedule', 'schedule');
        Route::get('/today', 'attendance_today');
        Route::get('/summary', 'summary_transaction_not_deposit_yet');
        Route::post('/deposit', 'deposit');
        Route::get('/{id}', 'detail_attendance');
    });

    // TRANSACTION
    Route::controller(ApiTransactionController::class)->prefix('/transaction')->group(function () {
        Route::get('/products', 'products');
        Route::get('/payments', 'payments');
        Route::post('/create', 'create');
    });


    // REPORT
    Route::controller(ApiReportController::class)->prefix('/report')->group(function () {
        Route::get('/sales', 'sales_report');
        Route::get('/sales/summary', 'summary_sales_report');
        Route::get('/attendances', 'attendance_report');
        Route::get('/attendances/summary', 'summary_attendance_report');
        Route::get('/deposit', 'deposit_report');
        Route::get('/deposit/summary', 'summary_deposit_report');
        Route::get('/schedules', 'schedules');
    });

    // OVERTIME APPLICATION
    Route::controller(ApiOvertimeController::class)->prefix('/overtime')->group(function () {
        Route::get('/operators-and-shift', 'operators');
        Route::post('/create', 'create');
    });

    // MAINTENANCE REQUEST
    Route::controller(ApiMaintenanceRequestController::class)->prefix('/maintenance')->group(function () {
        Route::get('/lists', 'lists');
        Route::get('/items_and_outlets', 'items_and_outlets');
        Route::post('/create', 'create');
        Route::post('/assign', 'assign');
        Route::post('/approve', 'approve');
    });

    // ITEM REQUEST
    Route::controller(ApiItemRequestController::class)->prefix('/item_requests')->group(function () {
        Route::get('/lists', 'lists');
        Route::get('/items_and_outlets', 'items_and_outlets');
        Route::post('/create', 'create');
        Route::post('/accept', 'accept');
    });

    // LEAVE REQUEST
    Route::controller(ApiLeaveRequestController::class)->prefix('/leave')->group(function () {
        Route::get('/lists', 'lists');
        Route::get('/operators', 'operators');
        Route::post('/create', 'create');
    });

});
