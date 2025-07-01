<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyewaan_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('penyewaan_id')->constrained()->onDelete('cascade');
        $table->foreignId('barang_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('paket_id')->nullable()->constrained()->onDelete('set null');
        $table->integer('jumlah');
        $table->decimal('harga_sewa', 10, 2);
        $table->decimal('subtotal', 10, 2)->default(0);
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyewaan_details');
    }
};
