@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="mb-4">
        <h3 class="fw-bold text-primary"><i class="bi bi-box-seam"></i> Laporan Stok Barang</h3>
        <p class="text-muted">Daftar seluruh barang beserta informasi stok, kategori, dan kondisinya.</p>
    </div>

    <!-- Cards Ringkasan -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-success">
                    <h6 class="fw-semibold">Barang Baik</h6>
                    <h4>{{ $jumlahBaik }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-warning">
                    <h6 class="fw-semibold">Rusak Ringan</h6>
                    <h4>{{ $jumlahRusakRingan }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-danger">
                    <h6 class="fw-semibold">Rusak Berat</h6>
                    <h4>{{ $jumlahRusakBerat }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <form method="GET" class="d-flex align-items-center gap-2 mb-3">
        <select name="kondisi" class="form-select w-auto">
            <option value="">Semua Kondisi</option>
            <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
            <option value="rusak ringan" {{ request('kondisi') == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
            <option value="rusak berat" {{ request('kondisi') == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
        </select>

        <select name="kategori_id" class="form-select w-auto">
            <option value="">Semua Kategori</option>
            @foreach ($kategoriList as $kategori)
                <option value="{{ $kategori->kategori_id }}" {{ request('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-filter"></i> Filter</button>
    </form>

    <!-- Tombol Export -->
    <div class="d-flex justify-content-end mb-3 gap-2">
        <a href="{{ route('laporan.stok.pdf', request()->only('kondisi', 'kategori_id')) }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
        <a href="{{ route('laporan.stok.excel', request()->only('kondisi', 'kategori_id')) }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
    </div>

    <!-- Tabel -->
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
                        <td><span class="badge bg-primary">{{ $barang->stok }}</span></td>
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
