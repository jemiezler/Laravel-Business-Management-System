<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([\App\Http\Middleware\CheckJwtToken::class])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::resource('users', UserController::class);
});
