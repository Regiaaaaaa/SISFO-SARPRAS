<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPeminjamanController extends Controller
{
    // Tampilkan halaman laporan peminjaman dengan filter
    public function index(Request $request)
{
    $query = Peminjaman::with(['user', 'barang']);

    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
        $query->whereBetween('tanggal_pinjam', [$request->tanggal_mulai, $request->tanggal_selesai]);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    } else {
        $query->whereIn('status', ['selesai', 'dikembalikan']); // ✅ tampilkan dua status
    }

    $peminjamans = $query->latest()->get();

    return view('laporan.peminjaman', compact('peminjamans'));
}


    // Ekspor laporan peminjaman ke PDF
    public function exportPdf(Request $request)
{
    $query = Peminjaman::with(['user', 'barang']);

    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
        $query->whereBetween('tanggal_pinjam', [$request->tanggal_mulai, $request->tanggal_selesai]);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    } else {
        $query->whereIn('status', ['selesai', 'dikembalikan']);
    }

    $peminjamans = $query->get();

    return PDF::loadView('laporan.export.peminjaman_pdf', compact('peminjamans'))
              ->download('laporan_peminjaman.pdf');
}


    // Ekspor laporan peminjaman ke Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new PeminjamanExport($request), 'laporan_peminjaman.xlsx');
    }
}
