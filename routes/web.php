<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\FoodItemController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'vendor') {
        return redirect()->route('vendor.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/admin/stall/{stall}/toggle', [AdminController::class, 'toggleStallStatus'])->name('admin.stall.toggle');
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'dashboard'])->name('vendor.dashboard');
    Route::post('/vendor/stall', [VendorController::class, 'createStall'])->name('vendor.stall.create');
    Route::patch('/vendor/order/{order}/status', [VendorController::class, 'updateOrderStatus'])->name('vendor.order.status');
    Route::resource('vendor/menu', FoodItemController::class)->names('vendor.menu');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/stall/{stall}', [StudentController::class, 'showStall'])->name('student.stall.show');
    Route::post('/student/order', [OrderController::class, 'store'])->name('student.order.store');
    Route::get('/student/orders', [OrderController::class, 'index'])->name('student.orders');
    Route::post('/student/order/{order}/review', [OrderController::class, 'storeReview'])->name('student.order.review');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
