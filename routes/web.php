<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotografiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\PortfolioManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestimoniReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ServiceManagementController;

// Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Lupa Password
Route::get('/password/forgot', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');

// Reset Password
Route::get('/password/reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// PERTEMUAN 4 (Public routes)
Route::get('/home', [HomeController::class, 'index']);
Route::post('/home/signup', [HomeController::class, 'signup']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// Profile (semua role bisa akses)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// LOGIN ADMIN Middleware

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // User Management
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');

        // User Management
        // Create User
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');

        // Edit dan Update user
        Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');

        // Delete user
        Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    // Order Management
    Route::prefix('admin/orders')->name('admin.orders.')->group(function () {
        Route::get('/', [OrderManagementController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderManagementController::class, 'show'])->name('show');
        Route::put('/{id}/status', [OrderManagementController::class, 'updateStatus'])->name('updateStatus');
    });

    // Transaction Management
    Route::prefix('admin/transactions')->name('admin.transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
    });

    // Portfolio Management
    Route::prefix('admin/portfolio')->name('admin.portfolio.')->group(function () {
        Route::get('/', [PortfolioManagementController::class, 'index'])->name('index');
        Route::get('/create', [PortfolioManagementController::class, 'create'])->name('create');
        Route::post('/', [PortfolioManagementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PortfolioManagementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PortfolioManagementController::class, 'update'])->name('update');
        Route::delete('/{id}', [PortfolioManagementController::class, 'destroy'])->name('destroy');
    });

    // Service Management
    Route::prefix('admin/services')->name('admin.services.')->group(function () {
        Route::get('/', [ServiceManagementController::class, 'index'])->name('index');
        Route::get('/create', [ServiceManagementController::class, 'create'])->name('create');
        Route::post('/', [ServiceManagementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ServiceManagementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ServiceManagementController::class, 'update'])->name('update');
        Route::put('/{id}/toggle-status', [ServiceManagementController::class, 'toggleStatus'])->name('toggleStatus');
        Route::delete('/{id}', [ServiceManagementController::class, 'destroy'])->name('destroy');
    });

    // Testimoni Report
    Route::prefix('admin/testimoni')->name('admin.testimoni.')->group(function () {
        Route::get('/', [TestimoniReportController::class, 'index'])->name('index');
    });
});


//Login Fotografi Middleware

Route::middleware(['auth', 'role:fotografer'])->group(function () {
    Route::get('/fotografer/dashboard', [FotografiController::class, 'show'])->name('fotografer.dashboard');
    Route::get('/home-fotografi', [FotografiController::class, 'show'])->name('fotografer.home');
});

// Login Pelanggan MiddleWare

Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', function () {
        return view('home-admin'); //Masih ke view admin
    })->name('pelanggan.dashboard');
});
