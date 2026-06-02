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

    Route::post('kamar/bulk-delete', [KamarController::class, 'bulkDestroy'])->name('kamar.bulkDestroy');
    Route::resource('kamar', KamarController::class);

    /*
    |--------------------------------------------------------------------------
    | Penyewa
    |--------------------------------------------------------------------------
    */

    Route::post('penyewa/bulk-delete', [PenyewaController::class, 'bulkDestroy'])->name('penyewa.bulkDestroy');
    Route::resource('penyewa', PenyewaController::class);

    /*
    |--------------------------------------------------------------------------
    | Pembayaran
    |--------------------------------------------------------------------------
    */

    Route::post('pembayaran/bulk-delete', [PembayaranController::class, 'bulkDestroy'])->name('pembayaran.bulkDestroy');
    Route::resource('pembayaran', PembayaranController::class);

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
