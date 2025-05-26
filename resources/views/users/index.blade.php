@extends('layouts.app')
@section('title', 'Daftar User')

@push('styles')
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .page-header {
        background: linear-gradient(45deg, #4e73df, #2e59d9);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        color: white;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.2);
    }

    .btn-primary {
        background: #4e73df;
        border-color: #4e73df;
        border-radius: 8px;
        padding: 8px 18px;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: #2e59d9;
        box-shadow: 0 5px 15px rgba(46, 89, 217, 0.2);
        transform: translateY(-2px);
    }

    .table {
        vertical-align: middle;
    }

    .table thead th {
        background-color: #f8f9fc;
        color: #4e73df;
        font-weight: 600;
        border: none;
        padding: 15px;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fc;
    }

    .table td {
        padding: 15px;
        border-color: #f1f1f1;
    }

    .action-buttons .btn {
        width: 35px;
        height: 35px;
        padding: 0;
        line-height: 35px;
        border-radius: 8px;
        margin-right: 5px;
    }

    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 6px;
    }

    .badge-role-admin {
        background-color: #4e73df;
        color: white;
    }

    .badge-role-teacher {
        background-color: #1cc88a;
        color: white;
    }

    .badge-role-student {
        background-color: #f6c23e;
        color: white;
    }

    .empty-state {
        padding: 50px 20px;
        text-align: center;
    }

    .empty-state i {
        font-size: 60px;
        color: #d1d3e2;
        margin-bottom: 20px;
    }

    .empty-state p {
        color: #858796;
        font-size: 16px;
    }

    .alert-success {
        border-radius: 10px;
        border-left: 5px solid #1cc88a;
        background-color: #f0fbf7;
        color: #12855f;
    }

    .search-box {
        position: relative;
        max-width: 300px;
    }

    .search-box input {
        padding-left: 40px;
        border-radius: 30px;
        border: 1px solid #e3e6f0;
        height: 45px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #b7b9cc;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold m-0">Daftar Data User</h3>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-light">
            <i class="fas fa-plus me-2"></i> Tambah Data User
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <div class="search-box">

                        <input type="text" id="searchInput" class="form-control" placeholder="Cari user...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="userTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="20%">Email</th>
                            <th width="10%">Kelas</th>
                            <th width="15%">Jurusan</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2" style="width: 35px; height: 35px; background-color: #4e73df; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>{{ $user->name }}</div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->kelas ?? '-' }}</td>
                            <td>{{ $user->jurusan ?? '-' }}</td>
                            <td>
                                <div class="action-buttons text-center">
                                    <a href="{{ route('users.edit', ['user' => $user->user_id]) }}" class="btn btn-warning" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger delete-user" data-id="{{ $user->user_id }}" data-bs-toggle="tooltip" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <form id="delete-form-{{ $user->user_id }}" action="{{ route('users.destroy', ['user' => $user->user_id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <p>Belum ada user dalam sistem.</p>
                                    <a href="{{ route('users.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus me-1"></i> Tambah User Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Handle delete buttons
        const deleteButtons = document.querySelectorAll('.delete-user');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Yakin ingin hapus user ini?',
                    text: "Tindakan ini tidak bisa dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, hapus!',
                    cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
                    buttonsStyling: true,
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${userId}`).submit();
                    }
                });
            });
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            let filter = searchInput.value.toUpperCase();
            let table = document.getElementById('userTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let found = false;
                let td = tr[i].getElementsByTagName('td');

                for (let j = 1; j < 4; j++) { // Search in name, email, role columns
                    let txtValue = td[j].textContent || td[j].innerText;

                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        });
    });
</script>
@endpush