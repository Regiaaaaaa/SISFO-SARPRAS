@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary-emphasis">📋 Daftar Peminjaman</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
    @endif

    <div class="card shadow border-0 rounded-3">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="bg-light">
                        <th class="text-secondary fw-medium border-0 ps-4">User</th>
                        <th class="text-secondary fw-medium border-0">Barang</th>
                        <th class="text-secondary fw-medium border-0">Digunakan Untuk</th>
                        <th class="text-secondary fw-medium border-0">Tanggal Pinjam</th>
                        <th class="text-secondary fw-medium border-0">Tanggal Kembali</th>
                        <th class="text-secondary fw-medium border-0">Jumlah</th>
                        <th class="text-secondary fw-medium border-0">Status</th>
                        <th class="text-secondary fw-medium border-0 pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $p)
                    <tr data-id="{{ $p->peminjaman_id }}">
                        <td class="align-middle ps-4">{{ $p->user->name ?? $p->user_id }}</td>
                        <td class="align-middle">{{ $p->barang->nama_barang ?? $p->barang_id }}</td>
                        <td class="align-middle">{{ $p->digunakan_untuk }}</td>
                        <td class="align-middle">{{ $p->tanggal_pinjam }}</td>
                        <td class="align-middle">{{ $p->tanggal_kembali }}</td>
                        <td class="align-middle">{{ $p->jumlah }}</td>
                        <td class="status align-middle">
                            @if($p->status == 'menunggu')
    <span class="badge bg-warning text-dark px-3 py-2">Menunggu</span>
@elseif($p->status == 'dipinjam')
    <span class="badge bg-success px-3 py-2">Dipinjam</span>
@elseif($p->status == 'ditolak')
    <span class="badge bg-secondary px-3 py-2">Ditolak</span>
@else
    <span class="badge bg-dark px-3 py-2 text-white">{{ ucfirst($p->status) }}</span>
@endif

                        </td>
                        <td class="aksi align-middle pe-4">
                            @if($p->status == 'menunggu')
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-success approve-btn">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger reject-btn">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- jQuery & Bootstrap Icons --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
    $(function() {
        $('.approve-btn').click(function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.ajax({
                url: `/api/peminjaman/${id}/approve`,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function() {
                    row.find('.status').html('<span class="badge bg-success px-3 py-2">Dipinjam</span>');
                    row.find('.aksi').html('<span class="text-muted">-</span>');
                },
                error: function(xhr) {
                    alert('Gagal menyetujui: ' + xhr.responseText);
                }
            });
        });

        $('.reject-btn').click(function() {
            const row = $(this).closest('tr');
            const id = row.data('id');

            $.ajax({
                url: `/api/peminjaman/${id}/reject`,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function() {
                    row.find('.status').html('<span class="badge bg-secondary px-3 py-2">Ditolak</span>');
                    row.find('.aksi').html('<span class="text-muted">-</span>');
                },
                error: function(xhr) {
                    alert('Gagal menolak: ' + xhr.responseText);
                }
            });
        });
    });
</script>

<style>
    /* Gaya untuk tabel */
    .table th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    
    .table td {
        padding-top: 12px;
        padding-bottom: 12px;
        vertical-align: middle;
    }
    
    /* Gaya untuk badge status */
    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
        border-radius: 4px;
    }
    
    /* Hover effect pada baris tabel */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    /* Nomor dan detail seperti pada contoh gambar */
    tbody tr td:first-child {
        color: #0d6efd;
        font-weight: 500;
    }
</style>
@endsection