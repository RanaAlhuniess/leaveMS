<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
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
    Route::group(['prefix' => 'leaves', 'middleware' => 'scope:hr'], function () {
        Route::resource('/types', LeaveTypeController::class);
    });
    Route::group(['prefix' => 'employees', 'middleware' => 'scope:hr'], function () {
        Route::put('/{employee}/leave-balance', [EmployeeController::class, 'updateLeaveBalance'])->middleware('scope:hr');

    });

});
