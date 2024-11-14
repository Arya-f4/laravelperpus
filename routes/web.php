<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\RakController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
// Public routes
Route::get('/', [BukuController::class, 'index'])->name('home');
Route::get('/books', [BukuController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BukuController::class, 'show'])->name('books.show');
// Example to check role in a route
Route::get('/check-role', function () {
    if (Auth::user()->getRoleNames()->first() === 'admin') {
        return "User has admin role!";
    } else {
        return "User does not have admin role!";
    }
});

// Authentication routes
require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Peminjaman routes for peminjam
    Route::post('/books/{buku}/borrow', [PeminjamanController::class, 'requestBorrow'])->name('books.request-borrow');
    Route::get('/peminjaman', [PeminjamanController::class, 'userIndex'])->name('peminjaman.user-index');
    Route::get('/my-borrowings', [PeminjamanController::class, 'userIndex'])->name('peminjaman.user-index');
    Route::post('/books/{buku}/add-to-cart', [PeminjamanController::class, 'addToCart'])->name('books.add-to-cart');
    Route::get('/cart', [PeminjamanController::class, 'viewCart'])->name('peminjaman.cart');
    Route::post('/cart/checkout', [PeminjamanController::class, 'checkout'])->name('peminjaman.checkout');


});

// Admin and Petugas routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new DashboardController())->adminDashboard();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('admin.dashboard');

    // Admin routes for managing books, categories, and more
    Route::get('/admin/categories', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new KategoriController())->index();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('admin.categories.index');

    Route::get('/admin/books', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new BukuController())->index();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('admin.books.index');

//TODO: Rek tolong yang ini jadiin kayak yang diatas ya please, capek banget satu satu ngasih routing

    Route::resource('categories', KategoriController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('books', BukuController::class)->except(['index', 'show']);
    Route::resource('publishers', PenerbitController::class);
    Route::resource('racks', RakController::class);

    // Settings routes
    Route::get('/settings', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new SettingController())->index();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('settings.index');

    Route::post('/settings/update-cart-limit', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new SettingController())->updateCartLimit();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('settings.update-cart-limit');
});

// Petugas (non-admin but authorized users) routes
Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman', function () {
        if (Auth::user()->getRoleNames()->first() === 'petugas') {
            return (new PeminjamanController())->index();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('peminjaman.index');
});
