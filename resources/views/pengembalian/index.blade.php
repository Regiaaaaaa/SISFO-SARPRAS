@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary-emphasis">📋 Daftar Pengembalian</h2>
    </div>

    @if(session('success'))
    <div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
    @endif

    <div class="card shadow border-0 rounded-3">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="bg-light">
                        <th class="text-secondary fw-medium border-0 ps-4">ID</th>
                        <th class="text-secondary fw-medium border-0">User</th>
                        <th class="text-secondary fw-medium border-0">Barang</th>
                        <th class="text-secondary fw-medium border-0">Tanggal Kembali</th>
                        <th class="text-secondary fw-medium border-0">Kondisi Pengembalian</th>
                        <th class="text-secondary fw-medium border-0">Bukti Foto</th>
                        <th class="text-secondary fw-medium border-0">Status</th>
                        <th class="text-secondary fw-medium border-0 pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $p)
                    <tr data-id="{{ $p->pengembalian_id ?? 'null' }}">
                        <td class="align-middle ps-4">{{ $p->pengembalian_id }}</td>
                        <td class="align-middle">{{ $p->peminjaman->user->name ?? '-' }}</td>
                        <td class="align-middle">{{ $p->peminjaman->barang->nama_barang ?? '-' }}</td>
                        <td class="align-middle">{{ $p->tanggal_kembali }}</td>
                        <td class="align-middle">{{ $p->deskripsi_pengembalian }}</td>
                        <td class="align-middle">
                            @if($p->bukti_foto)
                                <a href="{{ asset('storage/' . $p->bukti_foto) }}" target="_blank" class="text-primary">Lihat Foto</a>
                            @else
                                <span class="text-muted">Tidak Ada</span>
                            @endif
                        </td>
                        <td class="status align-middle">
                            @if($p->status == 'menunggu')
                                <span class="badge bg-warning text-dark px-3 py-2">Menunggu</span>
                            @elseif($p->status == 'disetujui')
                                <span class="badge bg-success px-3 py-2">Disetujui</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">Ditolak</span>
                            @endif
                        </td>
                        <td class="aksi align-middle pe-4">
                            <div class="d-flex gap-2">
                                @if($p->status == 'menunggu')
                                    <button class="btn btn-sm btn-outline-success approve-btn">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger reject-btn">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                                <button class="btn btn-sm btn-outline-primary detail-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailModal"
                                    data-user="{{ $p->peminjaman->user->name ?? '-' }}"
                                    data-barang="{{ $p->peminjaman->barang->nama_barang ?? '-' }}"
                                    data-jumlah="{{ $p->peminjaman->jumlah ?? '-' }}"
                                    data-kembali="{{ $p->tanggal_kembali }}"
                                    data-kondisi="{{ $p->deskripsi_pengembalian }}"
                                    data-pinjam="{{ $p->peminjaman->tanggal_pinjam ?? '-' }}"
                                    data-kelas="{{ $p->peminjaman->user->kelas ?? '-' }}"
                                    data-jurusan="{{ $p->peminjaman->user->jurusan ?? '-' }}"
                                    data-foto="{{ $p->bukti_foto ? asset('storage/' . $p->bukti_foto) : '' }}"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Tidak ada data pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="detailModalLabel">Detail Pengembalian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p><strong>User:</strong> <span id="modal-user"></span></p>
        <p><strong>Kelas:</strong> <span id="modal-kelas"></span></p>
        <p><strong>Jurusan:</strong> <span id="modal-jurusan"></span></p>
        <p><strong>Barang:</strong> <span id="modal-barang"></span></p>
        <p><strong>Jumlah:</strong> <span id="detail-jumlah"></span></p>
        <p><strong>Tanggal Pinjam:</strong> <span id="modal-pinjam"></span></p>
        <p><strong>Tanggal Kembali:</strong> <span id="modal-kembali"></span></p>
        <p><strong>Kondisi Pengembalian:</strong> <span id="modal-kondisi"></span></p>
        <p><strong>Bukti Foto:</strong> 
            <br>
            <a href="#" id="modal-foto-link" target="_blank">
                <img id="modal-foto" src="" class="img-fluid rounded shadow mt-2" style="max-height: 200px;" alt="Bukti Foto">
            </a>
        </p>
      </div>
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

            if (!id || id === 'null') {
                alert('ID pengembalian tidak ditemukan.');
                return;
            }

            $.ajax({
                url: `/api/pengembalian/${id}/approve`,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function() {
                    row.find('.status').html('<span class="badge bg-success px-3 py-2">Disetujui</span>');
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

            if (!id || id === 'null') {
                alert('ID pengembalian tidak ditemukan.');
                return;
            }

            $.ajax({
                url: `/api/pengembalian/${id}/reject`,
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

       $('.detail-btn').click(function() {
    $('#modal-user').text($(this).data('user'));
    $('#modal-barang').text($(this).data('barang')); // 🟢 menampilkan nama barang
    $('#detail-jumlah').text($(this).data('jumlah')); // 🟢 menampilkan jumlah
    $('#modal-kembali').text($(this).data('kembali'));
    $('#modal-kondisi').text($(this).data('kondisi'));
    $('#modal-pinjam').text($(this).data('pinjam'));
    $('#modal-kelas').text($(this).data('kelas'));
    $('#modal-jurusan').text($(this).data('jurusan'));

    const foto = $(this).data('foto');
    if (foto) {
        $('#modal-foto').attr('src', foto);
        $('#modal-foto-link').attr('href', foto);
    } else {
        $('#modal-foto').attr('src', '');
        $('#modal-foto-link').attr('href', '#');
    }
});

    });
</script>

<style>
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

    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
        border-radius: 4px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    tbody tr td:first-child {
        color: #0d6efd;
        font-weight: 500;
    }

    .text-primary {
        text-decoration: none;
    }

    .text-primary:hover {
        text-decoration: underline;
    }
</style>
@endsection
