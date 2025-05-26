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
            $table->id('barang_id');
            $table->unsignedBigInteger('kategori_id'); 
            $table->string('nama_barang');
            $table->integer('stok');
            $table->string('code_barang')->unique();
            $table->string('merek')->nullable();
            $table->string('foto_barang')->nullable();
            $table->enum('kondisi_barang', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->timestamps();

            // Hubungkan dengan tabel kategori_barangs
            $table->foreign('kategori_id')
                  ->references('kategori_id') // Pastikan ini sesuai primary key di tabel kategori_barangs
                  ->on('kategori_barangs')
                  ->onDelete('cascade'); // Jika kategori dihapus, barang ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('barangs', function (Blueprint $table) {
        $table->dropForeign(['kategori_id']);
    });

    Schema::dropIfExists('barangs');
}

};