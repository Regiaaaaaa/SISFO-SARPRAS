@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid py-5 px-4">
    <h2 class="fw-bold text-primary d-flex align-items-center mb-4">
        <i class="fas fa-user-edit me-2 text-primary"></i> Edit Data User
    </h2>
    <p class="text-muted">Perbarui data user dengan lengkap dan benar.</p>

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

    <form action="{{ route('users.update', $user) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="name" class="form-label fw-medium">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label fw-medium">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <label for="kelas" class="form-label fw-medium">Kelas</label>
                <select name="kelas" class="form-select">
                    <option value="">-- Pilih Kelas (boleh kosong) --</option>
                    <option value="X" {{ old('kelas', $user->kelas) == 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ old('kelas', $user->kelas) == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ old('kelas', $user->kelas) == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="jurusan" class="form-label fw-medium">Jurusan</label>
                <select name="jurusan" class="form-select">
                    <option value="">-- Pilih Jurusan (boleh kosong) --</option>
                    <option value="RPL" {{ old('jurusan', $user->jurusan) == 'RPL' ? 'selected' : '' }}>RPL</option>
                    <option value="ANIMASI" {{ old('jurusan', $user->jurusan) == 'ANIMASI' ? 'selected' : '' }}>ANIMASI</option>
                    <option value="PSPT" {{ old('jurusan', $user->jurusan) == 'PSPT' ? 'selected' : '' }}>PSPT</option>
                    <option value="TJK" {{ old('jurusan', $user->jurusan) == 'TJK' ? 'selected' : '' }}>TJK</option>
                    <option value="TE" {{ old('jurusan', $user->jurusan) == 'TE' ? 'selected' : '' }}>TE</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label fw-medium">Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-save me-2"></i> Simpan Perubahan
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
