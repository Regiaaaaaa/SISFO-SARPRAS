<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;


class NotifikasiController extends Controller
{
    public function peminjamanMenunggu()
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $notifications = $peminjaman->map(function($item) {
            return [
                'id' => $item->id,
                'user_name' => $item->user->name,
                'nama_barang' => $item->barang->nama_barang,
                'created_at_human' => $item->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'count' => $peminjaman->count(),
            'notifications' => $notifications,
        ]);
    }
}
