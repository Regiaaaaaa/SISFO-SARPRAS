<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\UserController;

// Login untuk dapatkan token
Route::post('/login', [AuthController::class, 'loginApi']);

// Route yang butuh login (token)
Route::middleware('auth:sanctum')->group(function () {

    // User
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users', [UserController::class, 'index']);
    Route::put('/users', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Barang
    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/barang/{id}', [BarangController::class, 'show']);
    Route::post('/barang', [BarangController::class, 'store']);
    Route::put('/barang/{id}', [BarangController::class, 'update']);
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']);

    // Kategori
    Route::get('/kategori', [KategoriBarangController::class, 'index']);
    Route::get('/kategori/{id}', [KategoriBarangController::class, 'show']);
    Route::post('/kategori', [KategoriBarangController::class, 'store']);
    Route::put('/kategori/{id}', [KategoriBarangController::class, 'update']);
    Route::delete('/kategori/{id}', [KategoriBarangController::class, 'destroy']);

    // Peminjaman
    Route::get('/peminjaman/history', [PeminjamanController::class, 'historyAll']);
    Route::get('/peminjaman/user', [PeminjamanController::class, 'getByUser']);
    Route::get('/peminjaman', [PeminjamanController::class, 'index']);
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);
    Route::post('/peminjaman', [PeminjamanController::class, 'store']);
    Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update']);
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);
    


    //Approval Peminjaman 
    Route::put('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->where('id', '[0-9]+');
    Route::put('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->where('id', '[0-9]+');


    // Approval Pengembalian
    Route::put('/pengembalian/{id}/approve', [PengembalianController::class, 'approve'])->where('id', '[0-9]+');
    Route::put('/pengembalian/{id}/reject', [PengembalianController::class, 'reject'])->where('id', '[0-9]+');


    // Pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index']);
    Route::get('/pengembalian/{id}', [PengembalianController::class, 'show']);
    Route::post('/pengembalian', [PengembalianController::class, 'store']);
    Route::put('/pengembalian/{id}', [PengembalianController::class, 'update']);
    Route::delete('/pengembalian/{id}', [PengembalianController::class, 'destroy']);

    // Ambil data user login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
