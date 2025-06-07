<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/book', [BookController::class, 'index'])->name('book');
    Route::get('/borrow-detail', [BookController::class, 'index'])->name('borrow-detail');

    Route::get('/book-detail', function () {
        return view('page.book-detail');
    })->middleware(['auth', 'verified'])->name('book-detail');

    Route::get('/read-ebook', function () {
        return view('page.read-ebook');
    })->middleware(['auth', 'verified'])->name('read-ebook');

    Route::get('/borrow-detail', function () {
        return view('page.borrow-detail');
    })->middleware(['auth', 'verified'])->name('borrow-detail');

    Route::get('/confirmation', function () {
        return view('page.confirmation');
    })->middleware(['auth', 'verified'])->name('confirmation');

    Route::get('/bookmark', function () {
        return view('page.bookmark');
    })->middleware(['auth', 'verified'])->name('bookmark');

    Route::get('/history', function () {
        return view('page.history');
    })->middleware(['auth', 'verified'])->name('history');


    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
