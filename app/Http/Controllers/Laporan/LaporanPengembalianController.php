<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengembalianExport;

class LaporanPengembalianController extends Controller
{
    // Tampilkan halaman laporan pengembalian dengan filter
    public function index(Request $request)
    {
        $query = Pengembalian::with('peminjaman.user', 'peminjaman.barang');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_kembali', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'disetujui'); // default: hanya yang sudah disetujui
        }

        $pengembalians = $query->latest()->get();

        return view('laporan.pengembalian', compact('pengembalians'));
    }

    // Ekspor laporan pengembalian ke PDF
    public function exportPdf(Request $request)
    {
        $query = Pengembalian::with('peminjaman.user', 'peminjaman.barang');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_kembali', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'disetujui');
        }

        $pengembalians = $query->get();

        $pdf = PDF::loadView('laporan.export.pengembalian_pdf', compact('pengembalians'));
        return $pdf->download('laporan_pengembalian.pdf');
    }

    // Ekspor laporan pengembalian ke Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new PengembalianExport($request), 'laporan_pengembalian.xlsx');
    }
}
