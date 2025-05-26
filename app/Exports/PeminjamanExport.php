<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class PeminjamanExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Peminjaman::with(['user', 'barang']);

        if ($this->request->filled('tanggal_mulai') && $this->request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_pinjam', [$this->request->tanggal_mulai, $this->request->tanggal_selesai]);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        } else {
            $query->whereIn('status', ['selesai', 'dikembalikan']);
        }

        // Ubah ke bentuk collection yang hanya data yang ingin diekspor
        return $query->get()->map(function ($item) {
            return [
                'Nama User' => $item->user->name ?? '-',
                'Nama Barang' => $item->barang->nama_barang ?? '-',
                'digunakan_untuk' => $item->digunakan_untuk ?? '-',
                'Jumlah' => $item->jumlah,
                'Tanggal Pinjam' => $item->tanggal_pinjam,
                'Tanggal Kembali' => $item->tanggal_kembali,
                'Status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama User',
            'Nama Barang',
            'Digunakan Untuk',
            'Jumlah',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
        ];
    }
}
