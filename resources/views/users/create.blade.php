@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="container-fluid py-5 px-4">
    <h2 class="fw-bold text-primary d-flex align-items-center mb-4">
        <i class="fas fa-user-plus me-2 text-primary"></i> Tambah User Baru
    </h2>
    <p class="text-muted">Isi data user dengan lengkap dan benar.</p>

    {{-- Tampilkan Error --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="name" class="form-label fw-medium">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label fw-medium">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="password" class="form-label fw-medium">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label for="kelas" class="form-label fw-medium">Kelas</label>
                <select id="kelas" name="kelas" class="form-select">
                    <option value="">-- Pilih Kelas --</option>
                    <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="jurusan" class="form-label fw-medium">Jurusan</label>
                <select id="jurusan" name="jurusan" class="form-select">
                    <option value="">-- Pilih Jurusan --</option>
                    <option value="RPL" {{ old('jurusan') == 'RPL' ? 'selected' : '' }}>RPL</option>
                    <option value="ANIMASI" {{ old('jurusan') == 'ANIMASI' ? 'selected' : '' }}>ANIMASI</option>
                    <option value="PSPT" {{ old('jurusan') == 'PSPT' ? 'selected' : '' }}>PSPT</option>
                    <option value="TJKT" {{ old('jurusan') == 'TJKT' ? 'selected' : '' }}>TJKT</option>
                    <option value="TE" {{ old('jurusan') == 'TE' ? 'selected' : '' }}>TE</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-save me-2"></i> Simpan User
            </button>
        </div>
    </form>
</div>

<style>
    .form-control,
    .form-select {
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border-radius: 0.7rem;
        transition: 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4e54c8;
        box-shadow: 0 0 0 0.15rem rgba(78, 84, 200, 0.25);
    }

    .form-label {
        font-weight: 500;
    }

    .btn-primary {
        background-color: #4e54c8;
        border-color: #4e54c8;
    }

    .btn-primary:hover {
        background-color: #3d44b8;
    }
</style>
@endsection
