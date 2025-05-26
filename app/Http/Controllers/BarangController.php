<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // Tampilkan semua barang (API dan Web)
    public function index(Request $request)
    {
        $barangs = Barang::with('kategori')->get();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 200,
                'data' => $barangs,
            ]);
        }

        return view('barang.index', compact('barangs'));
    }

    // Tampilkan form create (Web only)
    public function create()
    {
        $kategoris = KategoriBarang::all();
        return view('barang.create', compact('kategoris'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_barangs,kategori_id',
            'nama_barang' => 'required|string',
            'stok' => 'required|integer',
            'code_barang' => 'required|string|unique:barangs,code_barang',
            'merek' => 'nullable|string',
            'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only([
            'kategori_id',
            'nama_barang',
            'stok',
            'code_barang',
            'merek',
            'kondisi_barang'
        ]);

        if ($request->hasFile('foto_barang')) {
            $data['foto_barang'] = $request->file('foto_barang')->store('barang', 'public');
        }

        $barang = Barang::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil ditambahkan.',
                'data' => $barang
            ], 201);
        }

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Tampilkan detail barang
    public function show(Request $request, $id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $barang
            ]);
        }

        return view('barang.show', compact('barang'));
    }

    // Tampilkan form edit (Web only)
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = KategoriBarang::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    // Update barang
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori_barangs,kategori_id',
            'nama_barang' => 'required|string',
            'stok' => 'required|integer',
            'code_barang' => 'required|string|unique:barangs,code_barang,' . $id . ',barang_id',
            'merek' => 'nullable|string',
            'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only([
            'kategori_id',
            'nama_barang',
            'stok',
            'code_barang',
            'merek',
            'kondisi_barang'
        ]);

        if ($request->hasFile('foto_barang')) {
            if ($barang->foto_barang && Storage::exists('public/' . $barang->foto_barang)) {
                Storage::delete('public/' . $barang->foto_barang);
            }

            $data['foto_barang'] = $request->file('foto_barang')->store('barang', 'public');
        }

        $barang->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil diperbarui.',
                'data' => $barang
            ]);
        }

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    // Hapus barang
    public function destroy(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->foto_barang && Storage::exists('public/' . $barang->foto_barang)) {
            Storage::delete('public/' . $barang->foto_barang);
        }

        $barang->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil dihapus.'
            ]);
        }

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
