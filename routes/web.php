<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotografiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\PortfolioManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestimoniReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ServiceManagementController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

// Route untuk serve gambar storage - HARUS di atas untuk prioritas
Route::get('/storage/layanan/{filename}', function ($filename) {
    $storagePath = 'public/layanan/' . $filename;
    
    // Gunakan Storage facade untuk cek file
    if (!Storage::exists($storagePath)) {
        \Log::error('Gambar tidak ditemukan: ' . $storagePath);
        abort(404, 'Gambar tidak ditemukan: ' . $filename);
    }
    
    // Ambil file menggunakan Storage
    $file = Storage::get($storagePath);
    $type = Storage::mimeType($storagePath);
    
    return Response::make($file, 200, [
        'Content-Type' => $type ?: 'image/jpeg',
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('filename', '[A-Za-z0-9._-]+')->name('storage.layanan');

Route::get('/storage/portfolio/{filename}', function ($filename) {
    $storagePath = 'public/portfolio/' . $filename;
    
    // Gunakan Storage facade untuk cek file
    if (!Storage::exists($storagePath)) {
        \Log::error('Gambar tidak ditemukan: ' . $storagePath);
        abort(404, 'Gambar tidak ditemukan: ' . $filename);
    }
    
    // Ambil file menggunakan Storage
    $file = Storage::get($storagePath);
    $type = Storage::mimeType($storagePath);
    
    return Response::make($file, 200, [
        'Content-Type' => $type ?: 'image/jpeg',
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('filename', '[A-Za-z0-9._-]+')->name('storage.portfolio');

// Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Lupa Password
Route::get('/password/forgot', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');

// Reset Password
Route::get('/password/reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// Profile (semua role bisa akses)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/**
 * ROUTE GROUP: ADMIN PANEL
 * Hanya bisa diakses oleh user dengan role 'admin' dan sudah login
 * URL Prefix: /admin/*
 * Route Name Prefix: admin.*
 */
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // Dashboard Admin - Menampilkan statistik dan grafik
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // User Management - Manajemen user (admin, fotografer, pelanggan)
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index'); // Daftar user
        Route::get('/create', [UserManagementController::class, 'create'])->name('create'); // Form tambah user
        Route::post('/', [UserManagementController::class, 'store'])->name('store'); // Simpan user baru
        Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit'); // Form edit user
        Route::put('/{id}', [UserManagementController::class, 'update'])->name('update'); // Update user
        Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy'); // Hapus user
    });

    // Order Management - Manajemen pesanan dari pelanggan
    Route::prefix('admin/orders')->name('admin.orders.')->group(function () {
        Route::get('/', [OrderManagementController::class, 'index'])->name('index'); // Daftar pesanan
        Route::get('/{id}', [OrderManagementController::class, 'show'])->name('show'); // Detail pesanan
        Route::put('/{id}/status', [OrderManagementController::class, 'updateStatus'])->name('updateStatus'); // Update status
        Route::put('/{id}/assign-fotografer', [OrderManagementController::class, 'assignFotografer'])->name('assignFotografer'); // Assign fotografer
    });

    // Transaction Management - Manajemen transaksi selesai
    Route::prefix('admin/transactions')->name('admin.transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index'); // Daftar transaksi (filter: metode, tanggal, search)
        Route::get('/{id}', [TransactionController::class, 'show'])->name('show'); // Detail transaksi
    });

    // Portfolio Management - Manajemen portofolio fotografer
    Route::prefix('admin/portfolio')->name('admin.portfolio.')->group(function () {
        Route::get('/', [PortfolioManagementController::class, 'index'])->name('index'); // Daftar portofolio (filter: kategori, search)
        Route::get('/create', [PortfolioManagementController::class, 'create'])->name('create'); // Form tambah portofolio
        Route::post('/', [PortfolioManagementController::class, 'store'])->name('store'); // Simpan portofolio baru
        Route::get('/{id}/edit', [PortfolioManagementController::class, 'edit'])->name('edit'); // Form edit portofolio
        Route::put('/{id}', [PortfolioManagementController::class, 'update'])->name('update'); // Update portofolio
        Route::delete('/{id}', [PortfolioManagementController::class, 'destroy'])->name('destroy'); // Hapus portofolio
    });

    // Service Management - Manajemen layanan/paket fotografi
    Route::prefix('admin/services')->name('admin.services.')->group(function () {
        Route::get('/', [ServiceManagementController::class, 'index'])->name('index'); // Daftar layanan (filter: status, search)
        Route::get('/create', [ServiceManagementController::class, 'create'])->name('create'); // Form tambah layanan
        Route::post('/', [ServiceManagementController::class, 'store'])->name('store'); // Simpan layanan baru
        Route::get('/{id}/edit', [ServiceManagementController::class, 'edit'])->name('edit'); // Form edit layanan
        Route::put('/{id}', [ServiceManagementController::class, 'update'])->name('update'); // Update layanan
        Route::put('/{id}/toggle-status', [ServiceManagementController::class, 'toggleStatus'])->name('toggleStatus'); // Toggle status (aktif/nonaktif)
        Route::delete('/{id}', [ServiceManagementController::class, 'destroy'])->name('destroy'); // Hapus layanan (tidak bisa jika sudah dipesan)
    });

    // Testimoni Report - Laporan dan analisis testimoni
    Route::prefix('admin/testimoni')->name('admin.testimoni.')->group(function () {
        Route::get('/', [TestimoniReportController::class, 'index'])->name('index'); // Laporan testimoni (filter: rating, tanggal, search)
    });
});

// Login Fotografi Middleware
Route::middleware(['auth', 'role:fotografer'])->group(function () {
    Route::get('/fotografer/dashboard', [FotografiController::class, 'show'])->name('fotografer.dashboard');
    
    // Jadwal routes
    Route::prefix('fotografer/jadwal')->name('fotografer.jadwal.')->group(function () {
        Route::get('/', [FotografiController::class, 'jadwalIndex'])->name('index');
    });
    
    // Pesanan routes
    Route::prefix('fotografer/pesanan')->name('fotografer.pesanan.')->group(function () {
        Route::get('/', [FotografiController::class, 'pesananIndex'])->name('index');
        Route::get('/{id}', [FotografiController::class, 'pesananShow'])->name('show');
        Route::put('/{id}/status', [FotografiController::class, 'pesananUpdateStatus'])->name('updateStatus');
    });
    
    // Portofolio routes
    Route::prefix('fotografer/portofolio')->name('fotografer.portofolio.')->group(function () {
        Route::get('/', [FotografiController::class, 'portofolioIndex'])->name('index');
        Route::get('/create', [FotografiController::class, 'portofolioCreate'])->name('create');
        Route::post('/', [FotografiController::class, 'portofolioStore'])->name('store');
        Route::get('/{id}', [FotografiController::class, 'portofolioShow'])->name('show');
        Route::get('/{id}/edit', [FotografiController::class, 'portofolioEdit'])->name('edit');
        Route::put('/{id}', [FotografiController::class, 'portofolioUpdate'])->name('update');
        Route::delete('/{id}', [FotografiController::class, 'portofolioDestroy'])->name('destroy');
    });
    
    // Chat routes untuk fotografer
    Route::prefix('fotografer/chat')->name('fotografer.chat.')->group(function () {
        Route::get('/', [ChatController::class, 'listChat'])->name('list');
        Route::get('/{id_pesanan}', [ChatController::class, 'index'])->name('index');
        Route::post('/{id_pesanan}', [ChatController::class, 'store'])->name('store');
        Route::get('/{id_pesanan}/messages', [ChatController::class, 'getMessages'])->name('getMessages');
    });
    
    // Notification routes
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unreadCount');
        Route::put('/{id}/read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::put('/read-all', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
    });
});

// Login Pelanggan Middleware
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
    
    // Booking routes
    Route::prefix('pelanggan/booking')->name('pelanggan.booking.')->group(function () {
        Route::get('/create', [PelangganController::class, 'bookingCreate'])->name('create');
        Route::post('/', [PelangganController::class, 'bookingStore'])->name('store');
        Route::get('/{id}/edit', [PelangganController::class, 'bookingEdit'])->name('edit');
        Route::put('/{id}', [PelangganController::class, 'bookingUpdate'])->name('update');
        Route::delete('/{id}', [PelangganController::class, 'bookingDestroy'])->name('destroy');
    });
    
    // Pesanan routes
    Route::prefix('pelanggan/pesanan')->name('pelanggan.pesanan.')->group(function () {
        Route::get('/', [PelangganController::class, 'pesananIndex'])->name('index');
    });
    
    // Layanan routes
    Route::prefix('pelanggan/layanan')->name('pelanggan.layanan.')->group(function () {
        Route::get('/', [PelangganController::class, 'layananIndex'])->name('index');
    });
    
    // Chat routes
    Route::prefix('pelanggan/chat')->name('pelanggan.chat.')->group(function () {
        Route::get('/', [ChatController::class, 'listChat'])->name('list');
        Route::get('/{id_pesanan}', [ChatController::class, 'index'])->name('index');
        Route::post('/{id_pesanan}', [ChatController::class, 'store'])->name('store');
        Route::get('/{id_pesanan}/messages', [ChatController::class, 'getMessages'])->name('getMessages');
    });
    
    // Portofolio routes
    Route::prefix('pelanggan/portofolio')->name('pelanggan.portofolio.')->group(function () {
        Route::get('/', [PelangganController::class, 'portofolioIndex'])->name('index');
    });
});