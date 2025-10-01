<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotografiController;

Route::get('/', function () {
    return view('welcome');
});


// ROUTE FOTOGRAFI
Route::get('/
' , [FotografiController::class, 'show']);
