<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CartController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/show/{id}', [HomeController::class, 'show'])->name('client.show');
Route::post('/giohang/them', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/giohang', [CartController::class, 'show'])->name('cart.show');
Route::post('/giohang/xoa/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Khu vực quản trị (admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('/products',       ProductController::class);
    Route::resource('/categories',     CategoryController::class);
    Route::resource('/banners',        BannerController::class);
    Route::resource('/users',UserController::class);
    

    // Thêm các resource khác nếu cần
});


// Route::resource('/category', CategoryController::class);

// Client routes
Route::get('/categories', [App\Http\Controllers\Client\CategoryController::class, 'index'])->name('client.categories.index');
Route::get('/categories/{id}', [App\Http\Controllers\Client\CategoryController::class, 'show'])->name('client.categories.show');

// Trang thanh toán client
Route::get('/checkout', [App\Http\Controllers\Client\CartController::class, 'checkoutForm'])->name('checkout.form');
Route::post('/checkout', [App\Http\Controllers\Client\CartController::class, 'checkoutSubmit'])->name('checkout.submit');