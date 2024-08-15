<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('login', [App\Http\Controllers\Admin\LoginController::class, 'loginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Admin\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');

Route::middleware(['admin'])->group(function () {

    Route::get('', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('profile');

    Route::resource('account', App\Http\Controllers\Admin\AccountController::class);
    Route::resource('logs', App\Http\Controllers\Admin\LogsController::class, ['only' => ['index', 'show']]);

    Route::prefix('budvar')
        ->name('budvar.')
        ->group(function () {
            Route::get('dashboard', [App\Http\Controllers\Admin\Budvar\DashboardController::class, 'index'])->name('dashboard');
            Route::resource('contact', App\Http\Controllers\Admin\Budvar\ContactController::class);
            Route::resource('page', App\Http\Controllers\Admin\Budvar\PageController::class);
        });

    //Route::resource('budvar/page', App\Http\Controllers\Admin\Budvar\PageController::class);
});
