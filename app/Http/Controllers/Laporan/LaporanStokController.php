<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StokBarangExport;

class LaporanStokController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->get();
        return view('laporan.stok', compact('barangs'));
    }

    public function exportPdf()
    {
        $barangs = Barang::with('kategori')->get();

        $pdf = PDF::loadView('laporan.export.stok_pdf', compact('barangs'));
        return $pdf->download('laporan_stok_barang.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new StokBarangExport, 'laporan_stok_barang.xlsx');
    }
}
