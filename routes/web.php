<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PerformanceReviewController;

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([\App\Http\Middleware\CheckJwtToken::class])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

    Route::resource('users', UserController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('leave', LeaveRequestController::class);
    Route::post('leave/{leave_request}/approve', [LeaveRequestController::class, 'approve'])->name('leave.approve');
    Route::post('leave/{leave_request}/reject', [LeaveRequestController::class, 'reject'])->name('leave.reject');
    Route::resource('payroll', PayrollController::class);
    Route::resource('performance', PerformanceReviewController::class);
});
