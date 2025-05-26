<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\KategoriBarang;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Hash;

class SarprasSeeder extends Seeder
{
    public function run()
    {
        // Buat admin (tanpa kelas & jurusan)
        $admin = User::updateOrCreate(
            ['email' => 'admin@sarpras.com'],
            [
                'name' => 'Admin Sarpras',
                'password' => Hash::make('sapras12345'),
                'role' => 'admin',
            ]
        );

       
        $user = User::updateOrCreate(
            ['email' => 'sav@gmail.com'],
            [
                'name' => 'SAV',
                'password' => Hash::make('vayra'),
                'role' => 'user',
                'kelas' => 'XII',
                'jurusan' => 'PSPT',
            ]
        );

        // Buat kategori barang
        $kategori1 = KategoriBarang::updateOrCreate(
            ['nama_kategori' => 'Elektronik'],
            ['deskripsi' => 'Peralatan elektronik']
        );

        $kategori2 = KategoriBarang::updateOrCreate(
            ['nama_kategori' => 'Mebel'],
            ['deskripsi' => 'Perabotan mebel']
        );
        
    }
}
