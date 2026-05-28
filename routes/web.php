<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('authenticate');

/*
|--------------------------------------------------------------------------
| Route Admin
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {

    Route::get('/', [DashboardController::class, 'index'
    ])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Kamar
    |--------------------------------------------------------------------------
    */

    Route::resource('kamar', KamarController::class);

    /*
    |--------------------------------------------------------------------------
    | Penyewa
    |--------------------------------------------------------------------------
    */

    Route::resource('penyewa', PenyewaController::class);

    /*
    |--------------------------------------------------------------------------
    | Pembayaran
    |--------------------------------------------------------------------------
    */

    Route::resource('pembayaran', PembayaranController::class);

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
