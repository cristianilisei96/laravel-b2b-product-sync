<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SupplierImportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\Shop\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('shop.cart.index');
    Route::post('/cart/products/{product}', [CartController::class, 'store'])->name('shop.cart.store');
    Route::patch('/cart/items/{cartItem}', [CartController::class, 'update'])->name('shop.cart.update');
    Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy'])->name('shop.cart.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/supplier-imports', [SupplierImportController::class, 'index'])->name('supplier-imports.index');
    Route::post('/supplier-imports', [SupplierImportController::class, 'store'])->name('supplier-imports.store');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
});

Route::get('/shop', [ShopProductController::class, 'index'])->name('shop.products.index');
Route::get('/shop/products/{product:slug}', [ShopProductController::class, 'show'])->name('shop.products.show');

require __DIR__ . '/auth.php';
