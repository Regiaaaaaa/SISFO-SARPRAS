<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $pengembalians = Pengembalian::with('peminjaman.user', 'peminjaman.barang')
            ->where('status', '!=', 'disetujui')
            ->latest()
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $pengembalians
            ]);
        }

        return view('pengembalian.index', compact('pengembalians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,peminjaman_id',
            'tanggal_kembali' => 'required|date',
            'deskripsi_pengembalian' => 'required|string',
            'bukti_foto' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('bukti_foto')) {
            $path = $request->file('bukti_foto')->store('bukti_foto', 'public');
        }

        $data = $request->all();
        $data['bukti_foto'] = $path;
        $data['status'] = 'menunggu';

        $pengembalian = Pengembalian::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pengembalian berhasil ditambahkan.',
                'data' => $pengembalian
            ], 201);
        }

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil ditambahkan.');
    }

    public function show(Request $request, $id)
    {
        $pengembalian = Pengembalian::with('peminjaman.user', 'peminjaman.barang')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $pengembalian
            ]);
        }

        return view('pengembalian.show', compact('pengembalian'));
    }

    public function update(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,peminjaman_id',
            'tanggal_kembali' => 'required|date',
            'deskripsi_pengembalian' => 'required|string',
            'status' => 'in:menunggu,disetujui,ditolak',
            'bukti_foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'peminjaman_id',
            'tanggal_kembali',
            'deskripsi_pengembalian',
            'status',
        ]);

        if ($request->hasFile('bukti_foto')) {
            $data['bukti_foto'] = $request->file('bukti_foto')->store('bukti_foto', 'public');
        }

        $pengembalian->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pengembalian berhasil diperbarui.',
                'data' => $pengembalian
            ]);
        }

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pengembalian berhasil dihapus.'
            ]);
        }

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil dihapus.');
    }

public function approve(Request $request, $id)
{
    $pengembalian = Pengembalian::with('peminjaman')->findOrFail($id);

    if ($pengembalian->status !== 'menunggu') {
        return response()->json(['error' => 'Pengembalian sudah diproses.'], 400);
    }

    // Set status pengembalian ke "disetujui"
    $pengembalian->update(['status' => 'disetujui']);

    // Pastikan update status peminjaman juga
    $peminjaman = \App\Models\Peminjaman::where('peminjaman_id', $pengembalian->peminjaman_id)->first();
    if ($peminjaman) {
        $peminjaman->update(['status' => 'dikembalikan']);
    }

    return response()->json(['message' => 'Pengembalian berhasil disetujui dan peminjaman diperbarui.']);
}



    public function reject(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->status !== 'menunggu') {
            return response()->json(['error' => 'Pengembalian sudah diproses.'], 400);
        }

        $pengembalian->update(['status' => 'ditolak']);

        return response()->json(['message' => 'Pengembalian berhasil ditolak.']);
    }
}
