@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h3 class="fw-bold text-primary">📄 Laporan Pengembalian</h3>
        <p class="text-muted">Lihat data pengembalian berdasarkan tanggal dan status.</p>
    </div>

    <form method="GET" action="{{ route('laporan.pengembalian') }}" class="card p-3 shadow-sm mb-4 border-0">
        <div class="row g-3 align-items-end">
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
                    @foreach(['menunggu', 'disetujui', 'ditolak'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('laporan.pengembalian.pdf', request()->all()) }}" class="btn btn-outline-danger">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
                <a href="{{ route('laporan.pengembalian.excel', request()->all()) }}" class="btn btn-outline-success">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th><i class="bi bi-person-circle"></i> User</th>
                    <th><i class="bi bi-box-seam"></i> Barang</th>
                    <th><i class="bi bi-calendar-check"></i> Tgl Kembali</th>
                    <th><i class="bi bi-journal-text"></i> Deskripsi</th>
                    <th><i class="bi bi-patch-check"></i> Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalians as $data)
                    <tr>
                        <td>{{ $data->peminjaman->user->name ?? '-' }}</td>
                        <td>{{ $data->peminjaman->barang->nama_barang ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->tanggal_kembali)->format('d/m/Y') }}</td>
                        <td>{{ $data->deskripsi_pengembalian }}</td>
                        <td>
                            @if ($data->status == 'disetujui')
                                <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Disetujui</span>
                            @elseif ($data->status == 'ditolak')
                                <span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock-fill"></i> Menunggu</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data pengembalian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
