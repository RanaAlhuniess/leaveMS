<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\LeaveTypeController;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('employees', EmployeeController::class);
    Route::group(['prefix' => 'leaves'], function () {
        Route::resource('/types', LeaveTypeController::class)->middleware('scope:hr');
        Route::post('/requests', [LeaveController::class, 'store']);
        Route::put('/{leaveRequest}/approve', [LeaveController::class, 'approve'])->middleware('scope:hr');
        Route::put('/{leaveRequest}/decline', [LeaveController::class, 'decline'])->middleware('scope:hr');
    });
    Route::group(['prefix' => 'employees'], function () {
        Route::put('/{employee}/leave-balance', [EmployeeController::class, 'updateLeaveBalance'])->middleware('scope:hr');
        Route::get('/me/leave-requests', [LeaveController::class, 'getEmployeeLeaveRequests']);

    });

});
