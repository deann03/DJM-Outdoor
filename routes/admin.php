<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\PenyewaanController;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('barang', BarangController::class)->except(['show']);

        Route::resource('paket', PaketController::class)->except(['show']);

        Route::get('/admin/penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan.index');
        Route::get('/admin/penyewaan/{penyewaan}', [PenyewaanController::class, 'admin'])->name('penyewaan.show');
        Route::patch('/penyewaan/{penyewaan}/verifikasi', [PenyewaanController::class, 'verifikasiPembayaran'])->name('penyewaan.verifikasi');
        Route::patch('/admin/penyewaan/{penyewaan}/{action}', [PenyewaanController::class, 'approveOrReject'])
        ->where('action', 'setujui|tolak')->name('penyewaan.approval');
        Route::patch('/admin/penyewaan/{penyewaan}/selesai', [PenyewaanController::class, 'markAsSelesai'])->name('penyewaan.selesai');
        Route::get('/admin/penyewaan/{penyewaan}/cetak', [PenyewaanController::class, 'cetakPDF'])->name('penyewaan.cetak');
    });