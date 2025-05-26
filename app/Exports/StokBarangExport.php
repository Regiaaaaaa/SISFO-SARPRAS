<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StokBarangExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Barang::with('kategori')->get()->map(function ($item) {
            return [
                'code_barang' => $item->code_barang ?? '-',
                'Nama Barang' => $item->nama_barang ?? '-',                
                'Kategori' => $item->kategori->nama_kategori ?? '-',
                'Jumlah Stok' => $item->stok ?? '0',
                'Merek' => $item->merek ?? '-',
                'Kondisi' => $item->kondisi_barang ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'code_barang',
            'nama_barang',
            'kategori',
            'Jumlah Stok',
            'merek',
            'Kondisi',
        ];
    }
}
