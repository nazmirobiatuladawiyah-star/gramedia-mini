<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\SubscriptionPackageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;

// Rute Halaman Home / Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/paket-langganan/{subscriptionPackage}', [SubscriptionPackageController::class, 'show'])
    ->name('subscription-packages.show');

// Rute Kategori Buku (wajib ada di luar middleware agar bisa diakses langsung)
Route::get('/kategori/{id}', [BookCategoryController::class, 'showBooks'])->name('category.books');

// Kelompok route yang hanya boleh diakses tamu (belum login)
Route::middleware('IsGuest')->group(function () {
    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'login'])->name('login.store');
});

// Kelompok route yang hanya boleh diakses setelah login
Route::middleware('IsLoggedIn')->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    // Kelompok khusus admin
    Route::prefix('admin')->name('admin.')->middleware('IsAdmin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('book-categories', BookCategoryController::class);
        Route::resource('package-book', SubscriptionPackageController::class);
        Route::resource('books', BookController::class);
    });
});
