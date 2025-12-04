<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotografiController;
use App\Http\Controllers\FotograferController;
use App\Http\Controllers\AuthFotograferController;
use App\Http\Controllers\JadwalFotograferController;
use App\Http\Controllers\PesananFotograferController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\KategoriPortofolioController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| LOGIN FOTOGRAFER (TANPA MIDDLEWARE)
|--------------------------------------------------------------------------
*/
Route::get('/fotografer/login', [AuthFotograferController::class, 'loginForm'])
    ->name('fotografer.login');

Route::post('/fotografer/login', [AuthFotograferController::class, 'loginProcess'])
    ->name('fotografer.login.process');


/*
|--------------------------------------------------------------------------
| ROUTE FOTOGRAFER (BUTUH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['fotografer'])
    ->prefix('fotografer')
    ->name('fotografer.')
    ->group(function () {

        // Dashboard + logout
        Route::get('/dashboard', [AuthFotograferController::class, 'dashboard'])->name('dashboard');
        Route::get('/logout', [AuthFotograferController::class, 'logout'])->name('logout');

        /*
        |--------------------------------------------------------------------------
        | JADWAL FOTOGRAFER
        |--------------------------------------------------------------------------
        */
        Route::get('/jadwal', [JadwalFotograferController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/create', [JadwalFotograferController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal/store', [JadwalFotograferController::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/edit/{id}', [JadwalFotograferController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/update/{id}', [JadwalFotograferController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/delete/{id}', [JadwalFotograferController::class, 'destroy'])->name('jadwal.delete');

        /*
        |--------------------------------------------------------------------------
        | PESANAN FOTOGRAFER
        |--------------------------------------------------------------------------
        */
        Route::get('/pesanan', [PesananFotograferController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/{id}', [PesananFotograferController::class, 'show'])->name('pesanan.show');
        Route::post('/pesanan/updateStatus/{id}', [PesananFotograferController::class, 'updateStatus'])->name('pesanan.updateStatus');

        /*
        |--------------------------------------------------------------------------
        | LAPORAN KINERJA
        |--------------------------------------------------------------------------
        */
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
        Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');
        Route::get('/laporan/edit/{id_laporan}', [LaporanController::class, 'edit'])->name('laporan.edit');
        Route::put('/laporan/update/{id_laporan}', [LaporanController::class, 'update'])->name('laporan.update');
        Route::delete('/laporan/destroy/{id_laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

        /*
        |--------------------------------------------------------------------------
        | KATEGORI PORTOFOLIO (HARUS SEBELUM PORTOFOLIO)
        |--------------------------------------------------------------------------
        */
        Route::get('/portofolio/kategori', [KategoriPortofolioController::class, 'index'])->name('portofolio.kategori.index');
        Route::get('/portofolio/kategori/create', [KategoriPortofolioController::class, 'create'])->name('portofolio.kategori.create');
        Route::post('/portofolio/kategori/store', [KategoriPortofolioController::class, 'store'])->name('portofolio.kategori.store');
        Route::get('/portofolio/kategori/edit/{id}', [KategoriPortofolioController::class, 'edit'])->name('portofolio.kategori.edit');
        Route::put('/portofolio/kategori/update/{id}', [KategoriPortofolioController::class, 'update'])->name('portofolio.kategori.update');
        Route::delete('/portofolio/kategori/destroy/{id}', [KategoriPortofolioController::class, 'destroy'])->name('portofolio.kategori.destroy');

        /*
        |--------------------------------------------------------------------------
        | PORTOFOLIO
        |--------------------------------------------------------------------------
        */
        Route::get('/portofolio', [PortofolioController::class, 'index'])->name('portofolio.index');
        Route::get('/portofolio/create', [PortofolioController::class, 'create'])->name('portofolio.create');
        Route::post('/portofolio/store', [PortofolioController::class, 'store'])->name('portofolio.store');
        Route::get('/portofolio/show/{id}', [PortofolioController::class, 'show'])->name('portofolio.show');
        Route::get('/portofolio/edit/{id}', [PortofolioController::class, 'edit'])->name('portofolio.edit');
        Route::put('/portofolio/update/{id}', [PortofolioController::class, 'update'])->name('portofolio.update');
        Route::delete('/portofolio/destroy/{id}', [PortofolioController::class, 'destroy'])->name('portofolio.destroy');
        Route::post('/portofolio/toggle-featured/{id}', [PortofolioController::class, 'toggleFeatured'])->name('portofolio.toggleFeatured');
        Route::delete('/portofolio/gambar/{id}', [PortofolioController::class, 'destroyGambar'])->name('portofolio.gambar.destroy');
        Route::post('/portofolio/gambar/set-cover/{id}', [PortofolioController::class, 'setCover'])->name('portofolio.gambar.setCover');

        /*
        |--------------------------------------------------------------------------
        | CHAT
        |--------------------------------------------------------------------------
        */
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/store', [ChatController::class, 'store'])->name('chat.store');
        Route::get('/chat/{userId}/messages', [ChatController::class, 'getMessages'])->name('chat.getMessages');
        Route::get('/chat/{userId}/new-messages', [ChatController::class, 'getNewMessages'])->name('chat.getNewMessages');
    });


/*
|--------------------------------------------------------------------------
| ROUTE ADMIN UNTUK CRUD FOTOGRAFER (DIPISAH, TIDAK BENTROK)
|--------------------------------------------------------------------------
*/
Route::prefix('admin/fotografer')->name('admin.fotografer.')->group(function () {
    Route::get('/', [FotograferController::class, 'index'])->name('index');
    Route::get('/create', [FotograferController::class, 'create'])->name('create');
    Route::post('/store', [FotograferController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [FotograferController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [FotograferController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [FotograferController::class, 'destroy'])->name('delete');
});


/*
|--------------------------------------------------------------------------
| ROUTE UMUM / PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/fotografi', [FotografiController::class, 'show']);
