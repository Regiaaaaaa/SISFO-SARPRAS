@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary-emphasis">📂 Kategori Barang</h2>
            <p class="text-muted mb-0">Kelola data kategori barang yang tersedia di sistem.</p>
        </div>
        <a href="javascript:void(0)" class="btn btn-primary rounded-3 shadow-sm d-flex align-items-center gap-2"
           data-bs-toggle="modal" data-bs-target="#createKategoriModal">
            <i class="bi bi-plus-circle"></i> <span>Tambah</span>
        </a>
    </div>

    @if(session('success'))
    <div class="alert {{ Str::contains(session('success'), 'dihapus') ? 'alert-danger' : 'alert-success' }} shadow-sm rounded-3 d-flex align-items-center gap-2">
        <i class="bi {{ Str::contains(session('success'), 'dihapus') ? 'bi-trash3' : 'bi-check-circle' }}"></i>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    <div class="card shadow border-0 rounded-3">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="bg-light">
                        <th class="text-secondary fw-medium border-0 ps-4">Nama Kategori</th>
                        <th class="text-secondary fw-medium border-0">Deskripsi</th>
                        <th class="text-secondary fw-medium border-0 pe-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $item)
                    <tr>
                        <td class="ps-4 align-middle" style="color: #0d6efd; font-weight: 500;">{{ $item->nama_kategori }}</td>
                        <td class="align-middle">{{ $item->deskripsi }}</td>
                        <td class="pe-4 align-middle">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-outline-warning btn-edit"
                                        data-id="{{ $item->kategori_id }}"
                                        data-nama="{{ $item->nama_kategori }}"
                                        data-deskripsi="{{ $item->deskripsi }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('kategori.destroy', $item->kategori_id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada kategori yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createKategoriModal" tabindex="-1" aria-labelledby="createKategoriModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('kategori.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">
            <i class="bi bi-folder-plus text-primary me-2"></i> Tambah Kategori
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Kategori</label>
          <input type="text" name="nama_kategori" class="form-control form-control-lg shadow-sm" placeholder="Contoh: Elektronik" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control shadow-sm" rows="3" placeholder="Tulis deskripsi singkat..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content" id="editKategoriForm">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">
            <i class="bi bi-pencil-square text-warning me-2"></i> Edit Kategori
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Kategori</label>
          <input type="text" name="nama_kategori" id="edit_nama_kategori" class="form-control form-control-lg shadow-sm" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" id="edit_deskripsi" class="form-control shadow-sm" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning text-white">Update</button>
      </div>
    </form>
  </div>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
    
    /* Hover effect pada baris tabel */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    /* Gaya untuk card */
    .card {
        transition: all 0.2s;
        border: none;
    }
    
    /* Gaya untuk tombol */
    .btn-primary {
        background-color: rgb(0, 0, 0);
        border: none;
    }
    
    .btn-warning {
        background-color: #f59e0b;
        border: none;
    }
    
    .btn-outline-warning {
        color: #f59e0b;
        border-color: #f59e0b;
    }
    
    .btn-outline-warning:hover {
        background-color: #f59e0b;
        color: white;
    }
    
    .btn-outline-danger {
        color: #ef4444;
        border-color: #ef4444;
    }
    
    .btn-outline-danger:hover {
        background-color: #ef4444;
        color: white;
    }
    
    /* Gaya untuk modal */
    .modal-content {
        border-radius: 0.5rem;
        border: none;
    }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit modal instance
    const editModal = new bootstrap.Modal(document.getElementById('editKategoriModal'));
    
    // Edit buttons
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const deskripsi = this.dataset.deskripsi;
            
            const form = document.getElementById('editKategoriForm');
            form.action = "{{ url('kategori') }}/" + id;
            
            document.getElementById('edit_nama_kategori').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi || '';
            
            editModal.show();
        });
    });
});
</script>
@endpush