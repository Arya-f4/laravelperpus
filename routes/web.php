<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DendaController;
use Illuminate\Support\Facades\Route;
use App\Models\Buku;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;


// Public routes
Route::get('/', [BukuController::class, 'index'])->name('home');


Route::get('/books', [BukuController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BukuController::class, 'show'])->name('books.show');


// Example role check
Route::get('/check-role', function () {

    if (auth()->user()->role_id == 1 ||auth()->user()->hasRole('admin')) {
        dd('User is an admin');
    } else {
        dd('User is not an admin');
    }

});


// Authentication routes
require __DIR__ . '/auth.php';
Route::middleware(['auth', 'roleid:1'])->get('/test-roleid', function () {
    return 'You have the correct role!';
});


// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-borrowings', [PeminjamanController::class, 'userIndex'])->name('peminjaman.user-index');

    // Books for authenticated users

    Route::get('/books/data', [BukuController::class, 'data'])->name('books.data');
    Route::post('/books/{buku}/add-to-cart', [PeminjamanController::class, 'addToCart'])->name('books.add-to-cart');


    Route::prefix('denda')->group(function () {
        Route::get('/', [DendaController::class, 'index'])->name('denda.index');
        Route::get('/pay/{denda}', [DendaController::class, 'pay'])->name('denda.pay');
    });
    // Borrowing routes
    Route::prefix('peminjaman')->group(function () {
        Route::post('/request', [PeminjamanController::class, 'requestBorrow'])->name('peminjaman.requestBorrow');
        Route::get('/confirm/{id}', [PeminjamanController::class, 'confirmBorrow'])->name('peminjaman.confirmBorrow');
        Route::get('/show/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::get('/return/{id}', [PeminjamanController::class, 'returnBook'])->name('peminjaman.returnBook');
        Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/my-borrowings', [PeminjamanController::class, 'userIndex'])->name('peminjaman.user-index');
        Route::get('/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::put('/{id}/approve', [PeminjamanController::class, 'approve'])
        ->name('peminjaman.approve')
        ->middleware('roleid:1,2');
        Route::delete('/{id}/cancel', [PeminjamanController::class, 'cancel'])->name('peminjaman.cancel');
        Route::get('/{id}/return', [PeminjamanController::class, 'returnBook'])
            ->name('peminjaman.return')
            ->middleware('role:admin,petugas');
       });

       Route::prefix('cart')->group(function () {
        Route::post('/add/{bookId}', [PeminjamanController::class, 'addToCart'])->name('books.add-to-cart');
        Route::get('/', [PeminjamanController::class, 'viewCart'])->name('peminjaman.cart');
        Route::delete('/remove/{bookId}', [PeminjamanController::class, 'removeFromCart'])->name('peminjaman.remove-from-cart');
        Route::post('/checkout', [PeminjamanController::class, 'checkout'])->name('peminjaman.checkout');
    });

    // Borrowing Route
    Route::post('/books/borrow', [PeminjamanController::class, 'requestBorrow'])->name('books.request-borrow');

    // Admin and Petugas routes
    Route::middleware(['auth','roleid:1'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

        // Resources
        Route::get('/users/all', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.destroy');
        
        Route::resource('categories', KategoriController::class);
        Route::resource('books', BukuController::class)->except(['index', 'show']);
        Route::resource('publishers', PenerbitController::class);
        Route::resource('racks', RakController::class);

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/update-cart-limit', [SettingController::class, 'updateCartLimit'])->name('settings.update-cart-limit');

        // Added routes
        Route::get('/peminjaman/{id}/return', [PeminjamanController::class, 'returnBook'])->name('peminjaman.return');
        Route::get('/peminjaman/denda/{id}', [PeminjamanController::class, 'showDenda'])->name('peminjaman.show-denda');
        Route::post('/denda/{id}/mark-as-paid', [DendaController::class, 'markAsPaid'])->name('denda.mark-as-paid');
      });
        // Dashboard


        // Petugas routes
        Route::middleware(['roleid:1,2'])->group(function () {
            Route::resource('peminjaman', PeminjamanController::class);
            Route::get('/peminjaman/{id}/delete', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
            Route::delete('peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
            Route::post('/peminjaman/pay-fine/{denda}', [PeminjamanController::class, 'payFine'])->name('peminjaman.pay-fine');
            Route::post('/peminjaman/update-fine-status/{denda}', [PeminjamanController::class, 'updateFineStatus'])
            ->name('peminjaman.update-fine-status');

        });


});
