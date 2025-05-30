@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-primary border-start border-4 ps-3">📄 Laporan Peminjaman</h3>
            <p class="text-muted">Lihat dan ekspor data peminjaman berdasarkan tanggal dan status.</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.peminjaman') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-calendar-date"></i> Dari Tanggal</label>
                    <input type="date" name="tanggal_mulai" class="form-control shadow-sm" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-calendar2-week"></i> Sampai Tanggal</label>
                    <input type="date" name="tanggal_selesai" class="form-control shadow-sm" value="{{ request('tanggal_selesai') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label d-block fw-semibold">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary flex-fill shadow-sm">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('laporan.peminjaman.pdf', request()->all()) }}" class="btn btn-outline-danger shadow-sm">
                            <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                        </a>
                        <a href="{{ route('laporan.peminjaman.excel', request()->all()) }}" class="btn btn-outline-success shadow-sm">
                            <i class="bi bi-file-earmark-excel-fill"></i> Excel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-nowrap">
                             <th><i class="bi bi-person-circle"></i> User</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th>Keterangan</th>
                            <th>Pinjam</th>
                            <th>Kembali</th>
                            <th class="text-center">✅ Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $data)
                        <tr>
                            <td>{{ $data->user->name ?? '-' }}</td>
                            <td>{{ $data->user->kelas ?? '-' }}</td>
                            <td>{{ $data->user->jurusan ?? '-' }}</td>
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
                
                                @endphp
                                <span class="badge rounded-pill bg-{{ $statusClass[$data->status] ?? 'secondary' }}">
                                    {{ $icons[$data->status] ?? '' }} {{ ucfirst($data->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">🔍 Tidak ada data peminjaman ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(isset($peminjamans) && method_exists($peminjamans, 'links'))
        <div class="card-footer bg-white border-top-0">
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

    .table tbody tr:hover {
        background-color: #f1f3f5;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.45em 0.8em;
    }

    .btn {
        font-weight: 500;
    }

    .btn i {
        margin-right: 4px;
    }

    .card {
        border-radius: 1rem;
    }
</style>
@endpush
@endsection
