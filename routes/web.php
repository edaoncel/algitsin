<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\ContactMessageController;

Route::get('/', [StoreController::class, 'index'])->name('store.index');

Route::get('/iletisim', function () {
    return view('contact');
})->name('contact');

Route::post('/iletisim', [ContactController::class, 'store'])->name('contact.store');
Route::resource('admin/products', ProductController::class);
Route::resource('admin/categories', CategoryController::class)->only(['index', 'store', 'destroy']);

Route::prefix('yonetim')->name('admin.')->group(function () {
    Route::get('giris', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('giris', [AuthController::class, 'login']);
    Route::post('cikis', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('admins', AdminManagementController::class);

        Route::resource('messages', ContactMessageController::class)->only(['index', 'destroy']);
    });
});

use App\Http\Controllers\Admin\AdminController;
Route::get('/yonetim', [AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/visitors', [AdminController::class, 'visitors'])->name('admin.visitors');

Route::delete('/admin/visitors/clear', [AdminController::class, 'clearVisitors'])->name('admin.visitors.clear');

Route::prefix('yonetim')->name('admin.')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::resource('products', App\Http\Controllers\ProductController::class);
    });
});

Route::resource('admin/categories', CategoryController::class)->except(['show']);