<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\OrderController;
use Illuminate\Support\Facades\Route;


Route::post('/giohang/xoa/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');

Route::post('/checkout', [CheckoutController::class, 'checkoutSubmit'])->name('checkout.submit');
Route::post('/orders/cancel/{id}', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/giohang/capnhat/{id_sanpham}/{id_bien}', [CartController::class, 'updateQuantity'])->name('cart.update');

Route::get('/show/{id}', [HomeController::class, 'show'])->name('client.show');
Route::post('/giohang/them', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/giohang', [CartController::class, 'show'])->name('cart.show');
Route::post('/giohang/xoa/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

Route::post('/cancel-order/{id}', [OrderController::class, 'cancel'])->name('orders.cancel');

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
