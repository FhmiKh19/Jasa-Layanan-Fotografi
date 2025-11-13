<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotografiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FotograferLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
// use App\Http\Controllers\PegawaiController;

Route::get('/', function () {
    return view('welcome');
});


// ROUTE FOTOGRAFI
// Route::get('/home_pegawai', [PegawaiController::class, 'index']);
Route::get('/home-fotografi' , [FotografiController::class, 'show']);
Route::post('/home/signup' ,[HomeController::class, 'signup']);


Route::get('/dashboard-fotografer', [FotograferLoginController::class, 'dashboard'])->name('dashboard.fotografer');
Route::post('/login-fotografer', [FotograferLoginController::class, 'login']);


// PERTEMUAN 7 REDIRECT
Route::get('/home',[HomeController::class, 'index'])->name('home');
Route::get('/login-fotografer', [FotograferLoginController::class, 'showLogin'])->name('login.fotografer');
Route::get('/logout-fotografer', [FotograferLoginController::class, 'logout'])->name('logout.fotografer');
Route::get('/go/{tujuan}', [HomeController::class, 'redirectTo'])->name('go');


// PERTEMUAN 8
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('pelanggan', [PelangganController::class, 'index'])->name('pelanggan.list');
Route::get('pelanggan/create',[PelangganController::class, 'create'])->name('pelanggan.create');
Route::post('pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan.store');


// PERTEMUAN 9
Route::get('pelanggan/edit/{param1}',[PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::get('pelanggan/edit',[PelangganController::class, 'update'])->name('pelanggan.update');
Route::get('pelanggan/destroy/{param1}',[PelangganController::class, 'destroy'])->name('pelanggan.destroy');
