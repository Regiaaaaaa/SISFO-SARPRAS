<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengembalianExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Pengembalian::with('peminjaman.user', 'peminjaman.barang');

        if ($this->request->filled('tanggal_mulai') && $this->request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_kembali', [
                $this->request->tanggal_mulai,
                $this->request->tanggal_selesai
            ]);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        } else {
            $query->where('status', 'disetujui');
        }

        return $query->get()->map(function ($item) {
            return [
                'Nama User' => $item->peminjaman->user->name ?? '-',
                'Kelas' => $item->peminjaman->user->kelas ?? '-',
                'Jurusan' => $item->peminjaman->user->jurusan ?? '-',
                'Nama Barang' => $item->peminjaman->barang->nama_barang ?? '-',
                'Jumlah' => $item->peminjaman->jumlah ?? '-',
                'Tanggal Pinjam' => $item->peminjaman->tanggal_pinjam ?? '-',
                'Tanggal Kembali' => $item->tanggal_kembali ?? '-',
                'Deskripsi' => $item->deskripsi_pengembalian ?? '-',
                'Status' => $item->status ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama User',
            'Kelas',
            'Jurusan',
            'Nama Barang',
            'Jumlah',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Deskripsi',
            'Status',
        ];
    }
}
