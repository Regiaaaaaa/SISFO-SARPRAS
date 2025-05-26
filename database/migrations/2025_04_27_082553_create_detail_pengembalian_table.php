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
        Schema::create('detail_pengembalian', function (Blueprint $table) {
            $table->id('id_detail_pengembalian');

            $table->unsignedBigInteger('id_detail_peminjaman');
            $table->foreign('id_detail_peminjaman')->references('id_detail_peminjaman')->on('detail_peminjaman')->onDelete('cascade');

            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')->references('barang_id')->on('barangs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengembalian');
    }
};
