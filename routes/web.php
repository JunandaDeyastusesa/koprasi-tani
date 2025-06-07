<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('dashboard', DashboardController::class);
// Proteksi semua route di bawah ini dengan middleware 'auth'
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });
    Route::get('/transaksi-member', [TransaksiController::class, 'viewTransaksiMember'])->name('viewTransaksiMember');
    Route::resource('members', MemberController::class);
    Route::resource('mitras', MitraController::class);
    Route::resource('inventaris', InventarisController::class);
    Route::resource('transaksi', TransaksiController::class);
});
