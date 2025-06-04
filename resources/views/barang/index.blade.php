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
    <div class="card shadow border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelBarang" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Kategori</th>
                            <th>Merek</th>
                            <th>Kode</th>
                            <th>Stok</th>
                            <th>Kondisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangs as $index => $barang)
                        <tr>
                            <td><strong>{{ $barang->nama_barang }}</strong></td>
                            <td>
                                @if($barang->foto_barang)
                                    <img src="{{ asset('storage/' . $barang->foto_barang) }}" alt="Foto Barang" width="50" height="50" class="rounded object-fit-cover">
                                @else
                                    <div class="text-muted"><i class="bi bi-box-seam fs-4"></i></div>
                                @endif
                            </td>
                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $barang->merek }}</td>
                            <td><code>{{ $barang->code_barang }}</code></td>
                            <td>
                                <span class="badge bg-dark text-white">{{ $barang->stok }}</span>
                            </td>
                            <td>
                                @php
                                    $kondisiWarna = match(strtolower($barang->kondisi_barang)) {
                                        'baik' => 'success',
                                        'rusak ringan' => 'warning',
                                        'rusak berat' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $kondisiWarna }} text-capitalize">
                                    {{ $barang->kondisi_barang }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('barang.edit', $barang->barang_id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('barang.destroy', $barang->barang_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- DataTables & Bootstrap Icons --}}
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tabelBarang').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "‹",
                    next: "›"
                },
                zeroRecords: "Tidak ditemukan data yang cocok"
            }
        });
    });
</script>
@endpush
@endsection
