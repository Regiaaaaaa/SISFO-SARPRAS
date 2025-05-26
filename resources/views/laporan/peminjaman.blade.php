@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-primary">📄 Laporan Peminjaman</h3>
            <p class="text-muted">Lihat data peminjaman berdasarkan tanggal dan status.</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.peminjaman') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        @foreach(['menunggu', 'disetujui', 'ditolak', 'dikembalikan'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-outline-primary w-100">🔍 Filter</button>
                    <a href="{{ route('laporan.peminjaman.pdf', request()->all()) }}" class="btn btn-outline-danger">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                    <a href="{{ route('laporan.peminjaman.excel', request()->all()) }}" class="btn btn-outline-success">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </a>

                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>👤 User</th>
                            <th>📦 Barang</th>
                            <th class="text-center">📦 Jumlah</th>
                            <th>📝 Keterangan</th>
                            <th>📅 Pinjam</th>
                            <th>📅 Kembali</th>
                            <th class="text-center">✅ Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $data)
                        <tr>
                            <td>{{ $data->user->name ?? '-' }}</td>
                            <td>{{ $data->barang->nama_barang ?? '-' }}</td>
                            <td class="text-center">{{ $data->jumlah }}</td>
                            <td>{{ $data->digunakan_untuk }}</td>
                            <td>{{ date('d/m/Y', strtotime($data->tanggal_pinjam)) }}</td>
                            <td>{{ date('d/m/Y', strtotime($data->tanggal_kembali)) }}</td>
                            <td class="text-center">
                                @php
                                $statusClass = [
                                'menunggu' => 'warning',
                                'disetujui' => 'success',
                                'ditolak' => 'danger',
                                'dikembalikan' => 'info',
                                ];
                                $icons = [
                                'menunggu' => '⏳',
                                'disetujui' => '✅',
                                'ditolak' => '❌',
                                'dikembalikan' => '📥',
                                ];
                                @endphp
                                <span class="badge bg-{{ $statusClass[$data->status] ?? 'secondary' }}">
                                    {{ $icons[$data->status] ?? '' }} {{ ucfirst($data->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">🔍 Tidak ada data peminjaman yang ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($peminjamans) && method_exists($peminjamans, 'links'))
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-center">
                {{ $peminjamans->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .table th {
        font-weight: 600;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.7em;
    }

    .btn-outline-primary,
    .btn-outline-danger,
    .btn-outline-success {
        font-weight: 500;
    }
</style>
@endpush
@endsection