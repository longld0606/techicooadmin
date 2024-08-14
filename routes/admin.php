<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('login', [App\Http\Controllers\Admin\LoginController::class, 'loginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Admin\LoginController::class, 'login']);

Route::middleware([ 'admin'])->group(function () {

    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');
    Route::get('profile', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('profile');
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
});
