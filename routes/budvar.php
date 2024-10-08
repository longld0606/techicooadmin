<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('login', [App\Http\Controllers\Budvar\LoginController::class, 'loginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Budvar\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Budvar\LoginController::class, 'logout'])->name('logout');

Route::middleware(['budvar', 'hasPermission'])->group(function () {

});
