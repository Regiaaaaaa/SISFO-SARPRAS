@extends('layouts.app')

@section('title', 'Tambah Barang Baru')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary d-flex align-items-center mb-3">
        <i class="bi bi-plus-circle me-2 fs-4"></i> Tambah Barang Baru
    </h3>
    <p class="text-muted mb-4">Isi data barang dengan lengkap dan benar.</p>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label for="kategori_id" class="form-label fw-semibold">Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="stok" class="form-label fw-semibold">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="code_barang" class="form-label fw-semibold">Kode Barang</label>
                <input type="text" name="code_barang" class="form-control" value="{{ old('code_barang') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="merek" class="form-label fw-semibold">Merek</label>
                <input type="text" name="merek" class="form-control" value="{{ old('merek') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="kondisi_barang" class="form-label fw-semibold">Kondisi</label>
                <select name="kondisi_barang" class="form-select" required>
                    <option value="">-- Pilih Kondisi --</option>
                    @foreach(['Baik', 'Rusak Ringan', 'Rusak Berat'] as $kondisi)
                        <option value="{{ $kondisi }}" {{ old('kondisi_barang') == $kondisi ? 'selected' : '' }}>
                            {{ $kondisi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mb-4">
                <label for="foto_barang" class="form-label fw-semibold">Foto Barang (Opsional)</label>
                <input type="file" name="foto_barang" class="form-control">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                ← Kembali
            </a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                💾 Simpan Barang
            </button>
        </div>
    </form>
</div>
@endsection
