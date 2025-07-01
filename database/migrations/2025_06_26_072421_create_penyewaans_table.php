<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyewaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('tanggal_ambil');
            $table->dateTime('tanggal_kembali');
            $table->dateTime('tanggal_pengembalian')->nullable();

            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'dibatalkan', 'dikembalikan', 'selesai'])->default('menunggu');
            
            $table->enum('metode_pembayaran', ['transfer', 'cod'])->default('transfer');
            $table->enum('status_pembayaran', ['belum_bayar', 'menunggu_verifikasi', 'terverifikasi'])->default('belum_bayar');
            $table->string('bukti_pembayaran')->nullable();
            $table->dateTime('tanggal_bayar')->nullable();

            $table->enum('metode_pengambilan', ['ambil', 'antar'])->default('ambil');
            $table->text('alamat_pengantaran')->nullable();
            $table->string('jenis_identitas');
            $table->string('nomor_identitas');
            $table->string('file_identitas')->nullable();
            
            $table->integer('total_hari')->default(0);
            $table->decimal('total_biaya', 10, 2)->default(0);
            $table->decimal('denda', 10, 2)->default(0);
            $table->decimal('total_bayar', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyewaans');
    }
};
