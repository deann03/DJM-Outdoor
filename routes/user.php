<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\KatalogController;
use App\Http\Controllers\User\PaketController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\PenyewaanController;
use App\Http\Controllers\User\DashboardController;

Route::middleware(['auth', 'verified', 'user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::view('/informasi/tentang', 'user.informasi.tentang')->name('informasi.tentang');
        Route::view('/informasi/kontak', 'user.informasi.kontak')->name('informasi.kontak');

        Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
        Route::get('/katalog/paket/{paket}', [PaketController::class, 'show'])->name('paket.show');

        Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
        Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
        Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
        Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

        Route::get('user/penyewaan/{penyewaan}', [PenyewaanController::class, 'show'])->name('penyewaan.show');
        Route::get('/penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan.index');
        Route::get('/penyewaan/checkout', [PenyewaanController::class, 'create'])->name('penyewaan.create');
        Route::post('/penyewaan', [PenyewaanController::class, 'store'])->name('penyewaan.store');
        Route::patch('/penyewaan/{penyewaan}/batal', [PenyewaanController::class, 'batal'])->name('penyewaan.batal');
        Route::patch('/penyewaan/{penyewaan}/kembalikan', [PenyewaanController::class, 'kembalikan'])->name('penyewaan.kembalikan');
        Route::get('{penyewaan}/cetak-pdf', [PenyewaanController::class, 'cetakPDF'])->name('penyewaan.cetak');
    });