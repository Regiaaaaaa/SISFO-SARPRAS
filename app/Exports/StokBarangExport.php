<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StokBarangExport implements FromCollection, WithHeadings
{
    protected $barangs;

    public function __construct($barangs)
    {
        $this->barangs = $barangs;
    }

    public function collection()
    {
        return $this->barangs->map(function ($item) {
            return [
                'code_barang' => $item->code_barang ?? '-',
                'nama_barang' => $item->nama_barang ?? '-',                
                'kategori' => $item->kategori->nama_kategori ?? '-',
                'jumlah_stok' => $item->stok ?? '0',
                'merek' => $item->merek ?? '-',
                'kondisi' => $item->kondisi_barang ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'code_barang',
            'nama_barang',
            'kategori',
            'jumlah_stok',
            'merek',
            'kondisi',
        ];
    }
}
