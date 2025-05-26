@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Greeting Section -->
    <div class="mb-5">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="h2 mb-1 fw-bold text-dark">
                    <span id="greeting"></span>, {{ Auth::user()->name ?? 'User' }}! 👋
                </h1>
                <p class="text-muted mb-0">Here's what's happening with your inventory today</p>
            </div>
            <div class="text-end">
                <small class="text-muted" id="current-time"></small>
            </div>
        </div>
    </div>

    <!-- Dashboard Cards Grid -->
    <div class="row g-4">
        <!-- Barang Terbaru -->
        <div class="col-xl-6 col-lg-6">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary bg-opacity-10 me-3">
                            <i class="fas fa-box-open text-primary"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0 fw-semibold">Barang Terbaru</h6>
                            <small class="text-muted">Latest items added</small>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 text-muted fw-medium">Nama Barang</th>
                                    <th class="border-0 text-muted fw-medium">Stok</th>
                                    <th class="border-0 text-muted fw-medium">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangTerbaru as $barang)
                                    <tr>
                                        <td class="border-0 fw-medium">{{ $barang->nama_barang }}</td>
                                        <td class="border-0">
                                            <span class="badge bg-light text-dark px-2">{{ $barang->stok }}</span>
                                        </td>
                                        <td class="border-0">
                                            <span class="badge bg-success bg-opacity-10 text-success px-2">
                                                {{ $barang->kondisi_barang }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4 border-0">
                                            <i class="fas fa-inbox mb-2 d-block text-muted"></i>
                                            Tidak ada barang terbaru
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peminjaman Terbaru -->
        <div class="col-xl-6 col-lg-6">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-info bg-opacity-10 me-3">
                            <i class="fas fa-hand-holding text-info"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0 fw-semibold">Peminjaman Terbaru</h6>
                            <small class="text-muted">Recent borrowing activities</small>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 text-muted fw-medium">Peminjam</th>
                                    <th class="border-0 text-muted fw-medium">Barang</th>
                                    <th class="border-0 text-muted fw-medium">Tanggal</th>
                                    <th class="border-0 text-muted fw-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjamanTerbaru as $p)
                                    <tr>
                                        <td class="border-0 fw-medium">
                                            {{ $p->user->name ?? 'User #' . $p->user_id }}
                                        </td>
                                        <td class="border-0">{{ $p->barang->nama_barang ?? 'Barang #' . $p->barang_id }}</td>
                                        <td class="border-0 text-muted">
                                            {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M') }}
                                        </td>
                                        <td class="border-0">
                                            @php
                                                $statusConfig = [
                                                    'Dipinjam' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icon' => 'fas fa-clock'],
                                                    'Dikembalikan' => ['class' => 'bg-success bg-opacity-10 text-success', 'icon' => 'fas fa-check'],
                                                    'Terlambat' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'icon' => 'fas fa-exclamation']
                                                ];
                                                $config = $statusConfig[$p->status] ?? $statusConfig['Dipinjam'];
                                            @endphp
                                            <span class="badge {{ $config['class'] }} px-2">
                                                <i class="{{ $config['icon'] }} me-1"></i>{{ $p->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4 border-0">
                                            <i class="fas fa-clipboard-list mb-2 d-block text-muted"></i>
                                            Belum ada peminjaman terbaru
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="col-xl-4 col-lg-6">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-warning bg-opacity-10 me-3">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-0 fw-semibold">Stok Menipis</h6>
                            <small class="text-muted">Items running low</small>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @forelse($barangStokMenipis as $barang)
                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle-sm bg-danger bg-opacity-10 me-2">
                                    <i class="fas fa-box text-danger"></i>
                                </div>
                                <span class="fw-medium">{{ $barang->nama_barang }}</span>
                            </div>
                            <span class="badge bg-danger px-2 fw-medium">{{ $barang->stok }}</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-check-circle mb-2 d-block text-success"></i>
                            Semua barang stoknya aman
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="col-xl-8 col-lg-6">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-success bg-opacity-10 me-3">
                                <i class="fas fa-bolt text-success"></i>
                            </div>
                            <div>
                                <h6 class="card-title mb-0 fw-semibold">Aktivitas Terbaru</h6>
                                <small class="text-muted">Recent system activities</small>
                            </div>
                        </div>
                        <div class="spinner-border spinner-border-sm text-muted d-none" id="activity-loader"></div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="aktivitas-terbaru" style="max-height: 300px; overflow-y: auto;">
                        @forelse($aktivitasTerbaru as $a)
    <div class="d-flex align-items-start py-3 border-bottom border-light">
        <div class="icon-circle-sm {{ $a['tipe'] === 'peminjaman' ? 'bg-primary' : 'bg-success' }} bg-opacity-10 me-3 mt-1">
            <i class="fas {{ $a['tipe'] === 'peminjaman' ? 'fa-hand-holding' : 'fa-undo' }} {{ $a['tipe'] === 'peminjaman' ? 'text-primary' : 'text-success' }}"></i>
        </div>
        <div class="flex-grow-1">
            <p class="mb-1">
                <strong>{{ $a['user'] }}</strong>
                {{ $a['tipe'] === 'peminjaman' ? 'melakukan peminjaman' : 'melakukan pengembalian' }}
                <strong>{{ $a['barang'] }}</strong>
            </p>
            <small class="text-muted">
                <i class="fas fa-clock me-1"></i>
                {{ \Carbon\Carbon::parse($a['waktu'])->diffForHumans() }}
            </small>
        </div>
    </div>
@empty
    <div class="text-center text-muted py-4">
        <i class="fas fa-history mb-2 d-block text-muted"></i>
        Tidak ada aktivitas terbaru
    </div>
@endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Dynamic greeting based on time
    function updateGreeting() {
        const now = new Date();
        const hour = now.getHours();
        let greeting;

        if (hour < 12) {
            greeting = "Good morning";
        } else if (hour < 17) {
            greeting = "Good afternoon";
        } else {
            greeting = "Good evening";
        }

        document.getElementById('greeting').textContent = greeting;

        // Update current time
        const timeString = now.toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        document.getElementById('current-time').textContent = timeString;
    }

    // Auto-refresh activities
    function refreshActivities() {
        const loader = document.getElementById('activity-loader');
        loader.classList.remove('d-none');

        fetch("{{ route('dashboard.aktivitas-terbaru') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('aktivitas-terbaru').innerHTML = html;
                loader.classList.add('d-none');
            })
            .catch(error => {
                console.error('Error refreshing activities:', error);
                loader.classList.add('d-none');
            });
    }

    // Initialize
    updateGreeting();
    setInterval(updateGreeting, 5000); // Update every minute
    setInterval(refreshActivities, 5000); // Refresh activities every 30 seconds

    // Page load animations
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>

<style>
    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-circle-sm {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 16px;
    }

    .card-header {
        border-radius: 16px 16px 0 0 !important;
    }

    .table th {
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }

    .text-muted {
        color: #6c757d !important;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .card-header {
            padding: 1rem !important;
        }
    }
</style>
@endsection