<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('kategori', ['tenda', 'alat_masak_makan', 'alat_tidur', 'sepatu', 'penerangan', 'lainnya']);
            $table->text('deskripsi')->nullable();
            $table->integer('stok');
            $table->decimal('harga_sewa', 10, 2);
            $table->string('gambar')->nullable();
            $table->boolean('khusus_paket')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
