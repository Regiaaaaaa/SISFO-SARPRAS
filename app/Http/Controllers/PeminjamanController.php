<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $peminjaman = Peminjaman::with(['user', 'barang', 'pengembalian'])
            ->whereNotIn('status', ['dikembalikan', 'selesai'])
            ->get();

        if ($request->wantsJson()) {
            return response()->json($peminjaman);
        }

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'barang_id' => 'required|exists:barangs,barang_id',
            'digunakan_untuk' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $data = $request->all();
        $data['status'] = 'menunggu';

        $peminjaman = Peminjaman::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Peminjaman berhasil ditambahkan.',
                'data' => $peminjaman
            ], 201);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function show(Request $request, $id)
    {
        $peminjaman = Peminjaman::with(['user', 'barang'])->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $peminjaman
            ]);
        }

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'barang_id' => 'required|exists:barangs,barang_id',
            'digunakan_untuk' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'in:menunggu,dipinjam,ditolak'
        ]);

        $data = $request->only([
            'user_id',
            'barang_id',
            'digunakan_untuk',
            'jumlah',
            'tanggal_pinjam',
            'tanggal_kembali',
            'status'
        ]);

        $peminjaman->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Peminjaman berhasil diperbarui.',
                'data' => $peminjaman
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Peminjaman berhasil dihapus.'
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function approve(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return response()->json(['error' => 'Peminjaman sudah diproses.'], 400);
        }

        // Optional: cek stok barang
        /*
        $barang = $peminjaman->barang;
        if ($peminjaman->jumlah > $barang->stok) {
            return response()->json(['error' => 'Stok barang tidak mencukupi.'], 400);
        }

        $barang->decrement('stok', $peminjaman->jumlah);
        */

        $peminjaman->update(['status' => 'dipinjam']);

        return response()->json(['message' => 'Peminjaman disetujui dan status sekarang dipinjam.']);
    }

    public function reject(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return response()->json(['error' => 'Peminjaman sudah diproses.'], 400);
        }

        $peminjaman->update(['status' => 'ditolak']);

        return response()->json(['message' => 'Peminjaman berhasil ditolak.']);
    }

    public function laporan(Request $request)
    {
        $peminjaman = Peminjaman::with(['user', 'barang', 'pengembalian'])
            ->whereIn('status', ['dikembalikan', 'selesai'])
            ->get();

        if ($request->wantsJson()) {
            return response()->json($peminjaman);
        }

        return view('laporan.peminjaman', compact('peminjaman'));
    }

    public function getByUser(Request $request)
{
    try {
        $user = auth()->user(); // Get user from token
        Log::info('User data:', ['user_id' => $user ? $user->user_id : 'null']); // Debug user
        
        if (!$user) {
            return response()->json([
                'error' => 'User not authenticated'
            ], 401);
        }
        
        $query = Peminjaman::with(['barang', 'pengembalian'])
            ->where('user_id', $user->user_id);
        
        Log::info('Base query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]); // Debug query
        
        $peminjaman = $query->where(function($q) {
                $q->where('status', 'dipinjam')
                  ->orWhere('status', 'Dipinjam');
            })
            ->get();
        
        Log::info('Found peminjaman count:', ['count' => count($peminjaman)]); // Debug results
            
        return response()->json(['data' => $peminjaman]);
    } catch (\Exception $e) {
        Log::error('Error fetching user peminjaman: '.$e->getMessage());
        return response()->json([
            'error' => 'Gagal ambil data peminjaman',
            'detail' => $e->getMessage()
        ], 500);
    }
}

public function historyAll(Request $request)
{
    $peminjaman = Peminjaman::with(['user', 'barang', 'pengembalian'])
        ->whereIn('status', ['dikembalikan', 'selesai']) // ✅ hanya histori
        ->orderBy('tanggal_pinjam', 'desc')
        ->get();

    return response()->json(['data' => $peminjaman]);
}




}
