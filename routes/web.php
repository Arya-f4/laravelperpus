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
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;


// Public routes
Route::get('/', function () {
    $books = Buku::with(['kategori', 'penerbit', 'rak'])->paginate(10);
    return view('home', compact('books'));
})->name('home');


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
require __DIR__ . '/auth.php';

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
    Route::delete('/cart/remove/{id}', [PeminjamanController::class, 'removeFromCart'])->name('peminjaman.remove-from-cart');
    Route::post('/cart/checkout', [PeminjamanController::class, 'checkout'])->name('peminjaman.checkout');

    Route::post('/peminjaman/requestBorrow', [PeminjamanController::class, 'requestBorrow'])->name('peminjaman.requestBorrow');
    Route::get('/peminjaman/confirmBorrow/{id}', [PeminjamanController::class, 'confirmBorrow'])->name('peminjaman.confirmBorrow');
    Route::get('/peminjaman/show/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/peminjaman/returnBook/{id}', [PeminjamanController::class, 'returnBook'])->name('peminjaman.returnBook');

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
    // Route::resource('categories', KategoriController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    // Route::resource('books', BukuController::class)->except(['index', 'show']);
    // Route::resource('publishers', PenerbitController::class);
    // Route::resource('racks', RakController::class);

    // categories
    Route::get('/categories/index', [KategoriController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [KategoriController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [KategoriController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [KategoriController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/update/{id}', [KategoriController::class, 'update'])->name('categories.update');
    Route::delete('/categories/destroy/{id}', [KategoriController::class, 'destroy'])->name('categories.destroy');


    // Books
    Route::get('/admin/books', [BukuController::class, 'index'])->name('books.index');
    Route::get('/admin/books/create', [BukuController::class, 'create'])->name('books.create');
    Route::post('/admin/books/store', [BukuController::class, 'store'])->name('books.store');
    Route::get('/admin/books/{id}/edit', [BukuController::class, 'edit'])->name('books.edit');
    Route::put('/admin/books/{id}/update', [BukuController::class, 'update'])->name('books.update');
    Route::delete('/admin/books/{id}/destroy', [BukuController::class, 'destroy'])->name('books.destroy');

    // Publishers
    Route::get('/admin/publishers', [PenerbitController::class, 'index'])->name('publishers.index');
    Route::get('/admin/publishers/create', [PenerbitController::class, 'create'])->name('publishers.create');
    Route::post('/admin/publishers/store', [PenerbitController::class, 'store'])->name('publishers.store');
    Route::get('/admin/publishers/{id}/edit', [PenerbitController::class, 'edit'])->name('publishers.edit');
    Route::put('/admin/publishers/{id}/update', [PenerbitController::class, 'update'])->name('publishers.update');
    Route::delete('/admin/publishers/{id}/destroy', [PenerbitController::class, 'destroy'])->name('publishers.destroy');



    // racks
    Route::get('/racks/index', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new RakController())->index();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('racks.index');

    Route::get('/racks/create', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new RakController())->create();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('racks.create');

    Route::get('/racks/store', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new RakController())->store();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('racks.store');

    Route::get('/racks/edit/{id}', function ($id) {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new App\Http\Controllers\RakController())->edit($id);
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('racks.edit');

    Route::get('/racks/update/{id}', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new RakController())->update();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('racks.update');

    Route::get('/racks/destroy/{id}', function () {
        if (Auth::user()->getRoleNames()->first() === 'admin') {
            return (new RakController())->destroy();
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('racks.destroy');


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
