<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StokBarangExport;
use App\Models\KategoriBarang;

class LaporanStokController extends Controller
{
    public function index(Request $request)
{
    $kondisi = $request->input('kondisi');
    $kategoriId = $request->input('kategori_id');

    $query = Barang::with('kategori');

    if ($kondisi) {
        $query->where('kondisi_barang', $kondisi);
    }

    if ($request->filled('kategori_id')) {
        $query->whereHas('kategori', function ($q) use ($request) {
            $q->where('kategori_id', $request->kategori_id); // ✅ fix di sini
        });
    }

    $barangs = $query->get();

    $jumlahBaik = Barang::where('kondisi_barang', 'baik')->count();
    $jumlahRusakRingan = Barang::where('kondisi_barang', 'rusak ringan')->count();
    $jumlahRusakBerat = Barang::where('kondisi_barang', 'rusak berat')->count();

    $kategoriList = KategoriBarang::orderBy('nama_kategori')->get();

    return view('laporan.stok', compact(
        'barangs',
        'kondisi',
        'kategoriId',
        'jumlahBaik',
        'jumlahRusakRingan',
        'jumlahRusakBerat',
        'kategoriList'
    ));
}


    public function exportPdf(Request $request)
    {
        $barangs = $this->filterBarangs($request);
        $pdf = Pdf::loadView('laporan.export.stok_pdf', compact('barangs'));
        return $pdf->download('laporan_stok_barang.pdf');
    }

    public function exportExcel(Request $request)
    {
        // Tidak perlu filterBarangs, karena StokBarangExport bisa langsung query ulang dengan filter
        return Excel::download(new StokBarangExport($request), 'laporan_stok_barang.xlsx');
    }

    private function filterBarangs(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('kondisi')) {
            $query->where('kondisi_barang', $request->kondisi);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        return $query->get();
    }
}
