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
                        <th class="text-secondary fw-medium border-0">Kelas</th>
                        <th class="text-secondary fw-medium border-0">Barang</th>
                        <th class="text-secondary fw-medium border-0">Kepetingan</th>
                        <th class="text-secondary fw-medium border-0">Jumlah</th>
                        <th class="text-secondary fw-medium border-0">Status</th>
                        <th class="text-secondary fw-medium border-0 pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $p)
                    <tr data-id="{{ $p->peminjaman_id }}">
                        <td class="align-middle ps-4">{{ $p->user->name ?? $p->user_id }}</td>
                        <td class="align-middle ps-4">{{ $p->user->kelas ?? '-' }}</td>
                        <td class="align-middle">{{ $p->barang->nama_barang ?? $p->barang_id }}</td>
                        <td class="align-middle">{{ $p->digunakan_untuk }}</td>
                        <td class="align-middle">{{ $p->jumlah }}</td>
                        <td class="status align-middle">
                            @if(strtolower($p->status) == 'menunggu')
                                <span class="badge bg-warning text-dark px-3 py-2">Menunggu</span>
                            @elseif(strtolower($p->status) == 'dipinjam')
                                <span class="badge bg-success px-3 py-2">Dipinjam</span>
                            @elseif(strtolower($p->status) == 'ditolak')
                                <span class="badge bg-secondary px-3 py-2">Ditolak</span>
                            @else
                                <span class="badge bg-dark px-3 py-2 text-white">{{ ucfirst($p->status) }}</span>
                            @endif
                        </td>
                        <td class="aksi align-middle pe-4">
                            @if(strtolower($p->status) == 'menunggu')
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-success approve-btn" data-peminjaman='@json($p)'>
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger reject-btn">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>
                            @elseif(strtolower($p->status) == 'dipinjam')
                                <button class="btn btn-sm btn-outline-info view-detail-btn"
                                    data-peminjaman='@json($p)' data-bs-toggle="modal" data-bs-target="#detailModal">
                                    <i class="bi bi-eye"></i>
                                </button>
                            @elseif(strtolower($p->status) == 'ditolak')
    <button class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $p->peminjaman_id }}">
        <i class="bi bi-trash"></i>
    </button>

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

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Peminjaman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nama:</strong> <span id="detail-nama"></span></p>
        <p><strong>Kelas:</strong> <span id="detail-kelas"></span></p>
        <p><strong>Jurusan:</strong> <span id="detail-jurursan"></span></p>
        <p><strong>Barang:</strong> <span id="detail-barang"></span></p>
        <p><strong>Jumlah:</strong> <span id="detail-jumlah"></span></p>
        <p><strong>Digunakan Untuk:</strong> <span id="detail-digunakan"></span></p>
        <p><strong>Tanggal Pinjam:</strong> <span id="detail-pinjam"></span></p>
        <p><strong>Tanggal Kembali:</strong> <span id="detail-kembali"></span></p>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
    $(function () {
        $(document).on('click', '.approve-btn', function () {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const peminjaman = $(this).data('peminjaman');

            $.ajax({
                url: `/api/peminjaman/${id}/approve`,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function () {
                    // Update status
                    row.find('.status').html('<span class="badge bg-success px-3 py-2">Dipinjam</span>');
                    
                    // Update aksi dengan tombol detail
                    row.find('.aksi').html(`
                        <button class="btn btn-sm btn-outline-info view-detail-btn"
                            data-peminjaman='${JSON.stringify(peminjaman)}' data-bs-toggle="modal" data-bs-target="#detailModal">
                            <i class="bi bi-eye"></i>
                        </button>
                    `);
                },
                error: function (xhr) {
                    alert('Gagal menyetujui: ' + xhr.responseText);
                }
            });
        });

        $(document).on('click', '.reject-btn', function () {
    const row = $(this).closest('tr');
    const id = row.data('id');
    
    console.log('Reject button clicked, ID:', id); // Debug log

    $.ajax({
        url: `/api/peminjaman/${id}/reject`,
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            console.log('Reject success, updating UI...'); // Debug log
            
            // Update status menjadi Ditolak
            row.find('.status').html('<span class="badge bg-secondary px-3 py-2">Ditolak</span>');
            
            // Update aksi dengan tombol delete - LANGSUNG MUNCUL
            row.find('.aksi').html(`
                <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${id}">
                    <i class="bi bi-trash"></i>
                </button>
            `);
            
            console.log('UI updated, delete button should be visible'); // Debug log
        },
        error: function (xhr) {
            console.log('Reject error:', xhr.responseText); // Debug log
            alert('Gagal menolak: ' + xhr.responseText);
        }
    });
});

        $(document).on('click', '.view-detail-btn', function () {
            const data = $(this).data('peminjaman');
            $('#detail-nama').text(data.user?.name ?? data.user_id);
            $('#detail-kelas').text(data.user?.kelas ?? '-');
            $('#detail-jurursan').text(data.user?.jurusan ?? '-');
            $('#detail-barang').text(data.barang?.nama_barang ?? data.barang_id);
            $('#detail-jumlah').text(data.jumlah);
            $('#detail-digunakan').text(data.digunakan_untuk);
            $('#detail-pinjam').text(data.tanggal_pinjam);
            $('#detail-kembali').text(data.tanggal_kembali);
        });

    $(document).on('click', '.delete-btn', function () {
    const id = $(this).data('id');
    console.log('Delete button clicked, ID:', id); // Debug log

    if (confirm('Yakin ingin menghapus data peminjaman ini?')) {
        console.log('User confirmed deletion'); // Debug log
        
        $.ajax({
            url: `/peminjaman/${id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            success: function (response) {
                console.log('Delete success:', response); // Debug log
                $(`tr[data-id="${id}"]`).remove();
                alert('Data berhasil dihapus.');
            },
            error: function (xhr, status, error) {
                console.log('Delete error details:');
                console.log('Status:', status);
                console.log('Error:', error);
                console.log('Response:', xhr.responseText);
                console.log('Status Code:', xhr.status);
                
                let errorMessage = 'Gagal menghapus data';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += ': ' + xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    errorMessage += ': ' + xhr.responseText;
                }
                
                alert(errorMessage);
            }
        });
    } else {
        console.log('User cancelled deletion'); // Debug log
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
</style>
@endsection