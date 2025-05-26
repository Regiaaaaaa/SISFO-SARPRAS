@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h3 class="fw-bold text-primary"><i class="bi bi-box-seam"></i> Laporan Stok Barang</h3>
        <p class="text-muted">Daftar seluruh barang beserta informasi stok, kategori, dan kondisinya.</p>
    </div>

    <div class="d-flex justify-content-end mb-3 gap-2">
        <a href="{{ route('laporan.stok.pdf') }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
        <a href="{{ route('laporan.stok.excel') }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle text-nowrap">
            <thead class="table-light">
                <tr>
                    <th><i class="bi bi-upc-scan"></i> Kode</th>
                    <th><i class="bi bi-box"></i> Nama Barang</th>
                    <th><i class="bi bi-tags"></i> Kategori</th>
                    <th><i class="bi bi-stack"></i> Stok</th>
                    <th><i class="bi bi-award"></i> Merek</th>
                    <th><i class="bi bi-check2-circle"></i> Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td>{{ $barang->code_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $barang->stok }}</span>
                        </td>
                        <td>{{ $barang->merek }}</td>
                        <td>
                            @php
                                $kondisi = strtolower($barang->kondisi_barang);
                                $badgeClass = match($kondisi) {
                                    'baik' => 'success',
                                    'rusak ringan' => 'warning',
                                    'rusak berat' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}">
                                <i class="bi bi-circle-fill"></i> {{ ucfirst($kondisi) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
