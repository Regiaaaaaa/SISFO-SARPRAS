<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $barangTerbaru = Barang::orderBy('created_at', 'desc')->take(5)->get();

        $peminjamanTerbaru = Peminjaman::with(['user', 'barang'])
                                       ->orderBy('created_at', 'desc')
                                       ->take(5)
                                       ->get();

        $barangStokMenipis = Barang::where('stok', '<', 5)
                                   ->orderBy('stok', 'asc')
                                   ->take(5)
                                   ->get();

        $pengembalianTerbaru = Pengembalian::with(['user', 'peminjaman.barang'])
                                           ->orderBy('created_at', 'desc')
                                           ->take(5)
                                           ->get();

        $aktivitasTerbaru = collect();

        foreach ($peminjamanTerbaru as $p) {
            $aktivitasTerbaru->push([
                'tipe' => 'peminjaman',
                'user' => $p->user->name ?? 'User #' . $p->user_id,
                'barang' => $p->barang->nama_barang ?? 'Barang #' . $p->barang_id,
                'waktu' => $p->created_at,
            ]);
        }

        foreach ($pengembalianTerbaru as $k) {
            $aktivitasTerbaru->push([
                'tipe' => 'pengembalian',
                'user' => $k->peminjaman->user->name ?? 'User #' . $k->peminjaman->user_id,
                'barang' => $k->peminjaman->barang->nama_barang ?? 'Barang #' . $k->peminjaman->barang_id,
                'waktu' => $k->created_at,
            ]);
        }

        $aktivitasTerbaru = $aktivitasTerbaru->sortByDesc('waktu')->take(8);

        return view('dashboard', compact(
            'barangTerbaru',
            'peminjamanTerbaru',
            'barangStokMenipis',
            'aktivitasTerbaru'
        ));
    }

    public function aktivitasTerbaru()
{
    $peminjamanTerbaru = Peminjaman::with(['user', 'barang'])
                                   ->orderBy('created_at', 'desc')
                                   ->take(5)
                                   ->get();

    $pengembalianTerbaru = Pengembalian::with(['peminjaman.user', 'peminjaman.barang'])
                                       ->orderBy('created_at', 'desc')
                                       ->take(5)
                                       ->get();

    $aktivitasTerbaru = collect();

    foreach ($peminjamanTerbaru as $p) {
        $aktivitasTerbaru->push([
            'tipe' => 'peminjaman',
            'user' => $p->user->name ?? 'User #' . $p->user_id,
            'barang' => $p->barang->nama_barang ?? 'Barang #' . $p->barang_id,
            'waktu' => $p->created_at,
        ]);
    }

    foreach ($pengembalianTerbaru as $k) {
        $aktivitasTerbaru->push([
            'tipe' => 'pengembalian',
            'user' => $k->peminjaman->user->name ?? 'User #' . $k->peminjaman->user_id,
            'barang' => $k->peminjaman->barang->nama_barang ?? 'Barang #' . $k->peminjaman->barang_id,
            'waktu' => $k->created_at,
        ]);
    }

    $aktivitasTerbaru = $aktivitasTerbaru->sortByDesc('waktu')->take(8);

    return view('partials.aktivitas-terbaru', compact('aktivitasTerbaru'));
}

}
