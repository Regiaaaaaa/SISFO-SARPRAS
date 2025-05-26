@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary-emphasis">📦 Daftar Barang</h2>
            <p class="text-muted mb-0">Kelola semua barang yang tersedia dalam sistem.</p>
        </div>
        <a href="{{ route('barang.create') }}" class="btn btn-primary rounded-pill shadow d-flex align-items-center gap-2 px-4 py-2">
            <i class="bi bi-plus-circle-fill"></i> <span class="fw-semibold">Tambah Barang</span>
        </a>
    </div>

    @if($barangs->isEmpty())
        <div class="alert alert-info rounded-4 shadow-sm text-center py-4">
            Belum ada barang yang ditambahkan.
        </div>
    @else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($barangs as $barang)
        <div class="col">
            <div class="card h-100 shadow-lg rounded-4 border-0 overflow-hidden transition-all" style="transition: all 0.3s;">
                {{-- Foto Barang --}}
                @if($barang->foto_barang)
                    <img src="{{ asset('storage/' . $barang->foto_barang) }}" class="card-img-top rounded-top-4" alt="Foto Barang" style="height: 160px; object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light rounded-top-4" style="height: 160px;">
                        <i class="bi bi-box-seam fs-1 text-muted"></i>
                    </div>
                @endif

                {{-- Info Barang --}}
                <div class="card-body py-3 px-4">
                    <h5 class="fw-bold text-dark">{{ $barang->nama_barang }}</h5>
                    <p class="mb-1 small text-muted"><strong>Kategori:</strong> {{ $barang->kategori->nama_kategori ?? '-' }}</p>
                    <p class="mb-1 small text-muted"><strong>Merek:</strong> {{ $barang->merek }}</p>
                    <p class="mb-1 small text-muted"><strong>Code:</strong> {{ $barang->code_barang }}</p>

                    <div class="d-flex align-items-center mb-2">
                        <strong class="me-2 small text-muted">Stok:</strong>
                        <span class="badge bg-dark text-white rounded-pill px-3 py-1">{{ $barang->stok }}</span>
                    </div>

                    @php
                        $kondisiWarna = match(strtolower($barang->kondisi_barang)) {
                            'baik' => 'success',
                            'rusak ringan' => 'warning',
                            'rusak berat' => 'danger',
                            default => 'secondary',
                        };
                    @endphp

                    <div class="d-flex align-items-center">
                        <strong class="me-2 small text-muted">Kondisi:</strong>
                        <span class="badge bg-{{ $kondisiWarna }} rounded-pill px-3 py-1 text-capitalize">
                            {{ $barang->kondisi_barang }}
                        </span>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="card-footer bg-transparent border-0 d-flex justify-content-between px-4 pb-4">
                    <a href="{{ route('barang.edit', $barang->barang_id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('barang.destroy', $barang->barang_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
