<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




//Route::get('login', ['as' => 'login',  'uses' => 'Auth\LoginController@showLoginForm']);
//Route::post('login', ['as' => '',    'uses' => 'Auth\LoginController@login']);
//Route::post('logout', ['as' => 'logout',    'uses' => 'Auth\LoginController@logout']);
// Password Reset Routes...
//Route::post('password/email', ['as' => 'password.email',    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
//Route::get('password/reset', ['as' => 'password.request',    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
//Route::post('password/reset', ['as' => 'password.update',    'uses' => 'Auth\ResetPasswordController@reset']);
//Route::get('password/reset/{token}', ['as' => 'password.reset',    'uses' => 'Auth\ResetPasswordController@showResetForm']);
// Registration Routes...
//Route::get('register', ['as' => 'register',    'uses' => 'Auth\RegisterController@showRegistrationForm']);
//Route::post('register', ['as' => '',    'uses' => 'Auth\RegisterController@register']);

Route::get('/info', function () {    return  phpinfo(); });

Route::get('login', [App\Http\Controllers\Web\LoginController::class, 'showLoginForm']);
Route::post('login', [App\Http\Controllers\Web\LoginController::class, 'login'])->name('login');
Route::post('logout', [App\Http\Controllers\Web\LoginController::class, 'logout'])->name('logout');
Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'index']);
Route::get('home', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');

