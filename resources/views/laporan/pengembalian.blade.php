@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="mb-4">
        <h3 class="fw-bold text-primary border-start border-4 ps-3">📄 Laporan Pengembalian</h3>
        <p class="text-muted">Lihat dan ekspor data pengembalian berdasarkan tanggal.</p>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('laporan.pengembalian') }}" class="card p-3 shadow-sm mb-4 border-0">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold"><i class="bi bi-calendar-date"></i> Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" class="form-control shadow-sm" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold"><i class="bi bi-calendar2-week"></i> Sampai Tanggal</label>
                <input type="date" name="tanggal_selesai" class="form-control shadow-sm" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary flex-fill shadow-sm">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('laporan.pengembalian.pdf', request()->all()) }}" class="btn btn-outline-danger shadow-sm">
                    <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                </a>
                <a href="{{ route('laporan.pengembalian.excel', request()->all()) }}" class="btn btn-outline-success shadow-sm">
                    <i class="bi bi-file-earmark-excel-fill"></i> Excel
                </a>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-nowrap">
                            <th><i class="bi bi-person-circle"></i> User</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th> Barang</th>
                             <th class="text-center">Jumlah</th>
                            <th>Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Keterangan</th>
                            <th> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengembalians as $data)
                        <tr>
                            <td>{{ $data->peminjaman->user->name ?? '-' }}</td>
                            <td>{{ $data->peminjaman->user->kelas ?? '-' }}</td>
                            <td>{{ $data->peminjaman->user->jurusan ?? '-' }}</td>
                            <td>{{ $data->peminjaman->barang->nama_barang ?? '-' }}</td>
                            <td class="text-center">{{ $data->peminjaman->jumlah ?? 0 }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->peminjaman->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_kembali)->format('d/m/Y') }}</td>
                            <td>{{ $data->deskripsi_pengembalian }}</td>
                            <td>
                                @php
                                $status = $data->status;
                                $badgeClass = match($status) {
                                    'disetujui' => 'success',
                                    'ditolak' => 'danger',
                                    default => 'warning text-dark'
                                };
                                $badgeIcon = match($status) {
                                    'disetujui' => 'bi-check-circle-fill',
                                    'ditolak' => 'bi-x-circle-fill',
                                    default => 'bi-clock-fill'
                                };
                                @endphp
                                <span class="badge rounded-pill bg-{{ $badgeClass }}">
                                    </i> {{ ucfirst($status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">🔍 Tidak ada data pengembalian ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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

    .btn i {
        margin-right: 4px;
    }

    .card {
        border-radius: 1rem;
    }
</style>
@endpush
@endsection
