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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id('pengembalian_id');
            $table->unsignedBigInteger('peminjaman_id');
            $table->foreign('peminjaman_id')
                ->references('peminjaman_id')
                ->on('peminjaman')
                ->onDelete('cascade');
            $table->date('tanggal_kembali');
            $table->string('deskripsi_pengembalian');
            $table->enum('status', ['disetujui', 'ditolak', 'menunggu'])->default('menunggu');
            $table->string('bukti_foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
