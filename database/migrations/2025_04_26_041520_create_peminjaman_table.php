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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('peminjaman_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('barang_id'); 
            $table->string('digunakan_untuk');
            $table->integer('jumlah');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->enum('status', ['disetujui', 'ditolak', 'menunggu', 'dikembalikan', 'Dipinjam'])->default('menunggu');
            $table->timestamps();
            $table->foreign('barang_id')->references('barang_id')->on('barangs')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
        
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['barang_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('peminjaman');
    }
};