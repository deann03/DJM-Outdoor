<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained()->onDelete('cascade');
            $table->foreignId('barang_id')->constrained()->onDelete('restrict');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_details');
    }
};
