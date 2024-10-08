<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('login', [App\Http\Controllers\Admin\LoginController::class, 'loginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Admin\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');

Route::middleware(['admin', 'hasPermission'])->group(function () {


    Route::get('', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [App\Http\Controllers\Admin\AccountController::class, 'profile'])->name('profile');

    Route::resource('account', App\Http\Controllers\Admin\AccountController::class);
    Route::resource('logs', App\Http\Controllers\Admin\LogsController::class, ['only' => ['index', 'show']]);


    Route::resource('role', App\Http\Controllers\Admin\RoleController::class);
    Route::get('/permission', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permission.index');
    Route::put('/permission/generator', [App\Http\Controllers\Admin\PermissionController::class, 'generator'])->name('permission.generator');
    Route::delete('/permission/destroy/{id}', [App\Http\Controllers\Admin\PermissionController::class, 'destroy'])->name('permission.destroy');

    Route::prefix('budvar')
        ->name('budvar.')
        ->group(function () {
            Route::get('', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
            Route::get('dashboard', [App\Http\Controllers\Admin\Budvar\DashboardController::class, 'index'])->name('dashboard');
            Route::resource('category', App\Http\Controllers\Admin\Budvar\CategoryController::class);
            Route::resource('page', App\Http\Controllers\Admin\Budvar\PageController::class);
            Route::get('page/clone/{id}', [App\Http\Controllers\Admin\Budvar\PageController::class, 'clone'])->name('page.clone');
            Route::resource('post', App\Http\Controllers\Admin\Budvar\PostController::class);
            Route::get('post/clone/{id}', [App\Http\Controllers\Admin\Budvar\PostController::class, 'clone'])->name('post.clone');
            Route::resource('product', App\Http\Controllers\Admin\Budvar\ProductController::class);
            Route::get('product/clone/{id}', [App\Http\Controllers\Admin\Budvar\ProductController::class, 'clone'])->name('product.clone');
            Route::resource('products', App\Http\Controllers\Admin\Budvar\ProductsController::class);
            Route::get('products/clone/{id}', [App\Http\Controllers\Admin\Budvar\ProductsController::class, 'clone'])->name('products.clone');
            Route::resource('history', App\Http\Controllers\Admin\Budvar\HistoryController::class);
            Route::resource('brand', App\Http\Controllers\Admin\Budvar\BrandController::class);
            Route::resource('media', App\Http\Controllers\Admin\Budvar\MediaController::class);
            Route::resource('slider', App\Http\Controllers\Admin\Budvar\SliderController::class);

            Route::get('menu/clone/{id}', [App\Http\Controllers\Admin\Budvar\MenuController::class, 'clone'])->name('menu.clone');
            Route::resource('menu', App\Http\Controllers\Admin\Budvar\MenuController::class);
            Route::resource('promotion', App\Http\Controllers\Admin\Budvar\PromotionController::class);

            Route::put('voucher/confirm/{id}/{customeId}', [App\Http\Controllers\Admin\Budvar\VoucherController::class,  'confirm'])->name('voucher.confirm');
            Route::resource('voucher', App\Http\Controllers\Admin\Budvar\VoucherController::class);

            Route::resource('contact', App\Http\Controllers\Admin\Budvar\ContactController::class);
            Route::resource('user', App\Http\Controllers\Admin\Budvar\UserController::class);

            Route::get('customer/address', [App\Http\Controllers\Admin\Budvar\CustomerController::class,  'address'])->name('customer.address');
            Route::get('customer/showChangePass/{id}', [App\Http\Controllers\Admin\Budvar\CustomerController::class,  'showChangePass'])->name('customer.showChangePass');
            Route::put('customer/authenticated/{id}', [App\Http\Controllers\Admin\Budvar\CustomerController::class,  'authenticated'])->name('customer.authenticated');
            Route::put('customer/changePass/{id}', [App\Http\Controllers\Admin\Budvar\CustomerController::class,  'changePass'])->name('customer.changePass');
            Route::resource('customer', App\Http\Controllers\Admin\Budvar\CustomerController::class);

            Route::get('setting', [App\Http\Controllers\Admin\Budvar\SettingController::class,  'index'])->name('setting.index');
            Route::post('setting/update', [App\Http\Controllers\Admin\Budvar\SettingController::class, 'update'])->name('setting.update');
        });

    //Route::resource('budvar/page', App\Http\Controllers\Admin\Budvar\PageController::class);
});
