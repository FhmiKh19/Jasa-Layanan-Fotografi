<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FotografiController;
use App\Http\Controllers\BookingController;

// Login & Register
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/masuk', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Google OAuth
Route::get('/auth/redirect-google', [LoginController::class, 'redirectToGoogle'])->name('redirect.google');
Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback']);

// Routes yang harus login
Route::middleware(['checkislogin'])->group(function () {
    Route::get('/pesan-fotografer', [FotografiController::class, 'pesanFotografer'])->name('pesan.fotografer');
    Route::get('/home-fotografi', [FotografiController::class, 'show'])->name('fotografi.home');

    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
});
