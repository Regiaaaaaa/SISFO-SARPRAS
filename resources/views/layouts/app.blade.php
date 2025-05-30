<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Management Sarpras')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
   
    <style>
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }

        .navbar {
            background: linear-gradient(135deg, #1f2c3f, #2d3e50);
            padding-top: 1rem;
            padding-bottom: 1rem;
            min-height: 90px;
            padding-left: 10vh;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.6rem;
            color: #fff;
            padding-right: 5vh;
        }

        .navbar-brand i {
            font-size: 1.6rem;
            margin-right: 8px;
        }

        .nav-link {
            color: #dee2e6 !important;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: 0.3s ease-in-out;
            padding: 10px 16px !important;
            border-radius: 8px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link i {
            margin-right: 6px;
        }

        .navbar-nav .nav-item {
            margin-right: 12px;
        }

        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: #f1f8ff;
            color: #007bff;
        }

        .logout-btn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border: none;
            padding: 10px 18px;
            border-radius: 30px;
            color: #fff;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            margin-left: 10vh;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #c0392b, #e74c3c);
        }

        .logout-btn i {
            margin-right: 6px;
        }

        .content {
            padding: 2rem;
            margin-top: 100px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-cubes text-primary"></i> Sarpras
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
    <div class="d-flex w-100 align-items-center justify-content-between">
        <!-- Centered Menu -->
        <ul class="navbar-nav mx-auto d-flex align-items-center">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            <!-- User Management -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="fas fa-users-cog"></i> Pengguna
                </a>
            </li>

            <!-- Data Master -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('kategori.*') || request()->routeIs('barang.*') ? 'active' : '' }}"
                   href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-database"></i> Data 
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}"><i class="fas fa-tags"></i> Kategori Barang</a></li>
                    <li><a class="dropdown-item {{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}"><i class="fas fa-box"></i> Data Barang</a></li>
                </ul>
            </li>

            <!-- Activity -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('peminjaman.*') || request()->routeIs('pengembalian.*') ? 'active' : '' }}"
                   href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-exchange-alt"></i> Activity
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}"><i class="fas fa-clipboard-list"></i> Peminjaman</a></li>
                    <li><a class="dropdown-item {{ request()->routeIs('pengembalian.*') ? 'active' : '' }}" href="{{ route('pengembalian.index') }}"><i class="fas fa-clipboard-list"></i> Pengembalian</a></li>
                </ul>
            </li>

            <!-- Report -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                   href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-chart-line"></i> Report
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item {{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}" href="{{ route('laporan.peminjaman') }}"><i class="fas fa-chart-bar"></i> Laporan Peminjaman</a></li>
                    <li><a class="dropdown-item {{ request()->routeIs('laporan.pengembalian') ? 'active' : '' }}" href="{{ route('laporan.pengembalian') }}"><i class="fas fa-file-alt"></i> Laporan Pengembalian</a></li>
                    <li><a class="dropdown-item {{ request()->routeIs('laporan.stok') ? 'active' : '' }}" href="{{ route('laporan.stok') }}"><i class="fas fa-file-invoice"></i> Laporan Stok Barang</a></li>
                </ul>
            </li>
        </ul>

        <!-- User Dropdown (Right-aligned) -->
        <ul class="navbar-nav ms-auto d-flex align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center text-white"
                   href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-lg me-1"></i>
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>

            

            <!-- Notifikasi Bell -->
@php
use App\Models\Peminjaman;
use App\Models\Pengembalian;

$notifPeminjaman = Peminjaman::where('status', 'menunggu')->with(['user', 'barang'])->latest()->take(5)->get();
$notifPengembalian = Pengembalian::where('status', 'menunggu')->with(['peminjaman.user', 'peminjaman.barang'])->latest()->take(5)->get();

$totalNotif = $notifPeminjaman->count() + $notifPengembalian->count();
@endphp

<!-- Icon Notifikasi -->

<li class="nav-item dropdown">
    <a class="nav-link position-relative p-2" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
        <i class="fas fa-bell text-white fs-5"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifBadge" style="display: none;">0</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow-sm" id="notifDropdownMenu" style="min-width: 320px;">
        <li class="dropdown-header fw-bold">🔔 Notifikasi</li>
        <li><a class="dropdown-item text-muted small text-center py-3">Loading...</a></li>
    </ul>
</li>

<!-- Pastikan TIDAK ADA text lain di luar element ini -->

<script>
async function fetchNotifikasi() {
    try {
        const response = await fetch('{{ route("api.notifikasi-combined") }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });
        
        if (!response.ok) throw new Error('Network response not ok');

        const data = await response.json();
        
        // Update badge
        const badge = document.getElementById('notifBadge');
        if (data.count > 0) {
            badge.textContent = data.count;
            badge.style.display = 'block';
        } else {
            badge.style.display = 'none';
        }

        // Update dropdown menu
        const dropdownMenu = document.getElementById('notifDropdownMenu');
        
        let menuHTML = '<li class="dropdown-header fw-bold">🔔 Notifikasi</li>';
        
        if (data.notifications && data.notifications.length > 0) {
            data.notifications.forEach((notif, index) => {
                const actionText = notif.type === 'peminjaman' ? 'mengajukan peminjaman' : 'mengajukan pengembalian';
                
                menuHTML += `
                    <li>
                        <a class="dropdown-item py-2" href="${notif.route || '#'}">
                            <div class="d-flex flex-column">
                                <span class="small">
                                    <strong>${notif.user_name}</strong> ${actionText} ${notif.nama_barang}
                                </span>
                                <small class="text-muted mt-1">
                                    <i class="fas fa-clock"></i> ${notif.created_at_human}
                                </small>
                            </div>
                        </a>
                    </li>
                `;
                
                // Add divider if not last item
                if (index < data.notifications.length - 1) {
                    menuHTML += '<li><hr class="dropdown-divider"></li>';
                }
            });
        } else {
            menuHTML += '<li><a class="dropdown-item text-muted small text-center py-3"></a></li>';
        }
        
        dropdownMenu.innerHTML = menuHTML;
        
    } catch (error) {
        console.error('Fetch notifikasi error:', error);
        const dropdownMenu = document.getElementById('notifDropdownMenu');
        dropdownMenu.innerHTML = `
            <li class="dropdown-header fw-bold">🔔 Notifikasi</li>
            <li><a class="dropdown-item text-muted small text-center py-3">Error memuat notifikasi</a></li>
        `;
    }
}

// Initial load
document.addEventListener('DOMContentLoaded', function() {
    fetchNotifikasi();
    // Update every 5 seconds
    setInterval(fetchNotifikasi, 5000);
});
</script>
        
        <!-- Notif Peminjaman -->
        @foreach ($notifPeminjaman as $p)
            <li>
                <a class="dropdown-item py-2" href="{{ route('peminjaman.index') }}">
                    <div class="d-flex flex-column">
                    </div>
                </a>
            </li>
            @if (!$loop->last || $notifPengembalian->count() > 0)
                <li><hr class="dropdown-divider"></li>
            @endif
        @endforeach

        <!-- Notif Pengembalian -->
        @foreach ($notifPengembalian as $k)
            <li>
                <a class="dropdown-item py-2" href="{{ route('pengembalian.index') }}">
                    <div class="d-flex flex-column">
                    </div>
                </a>
            </li>
            @if (!$loop->last)
                <li><hr class="dropdown-divider"></li>
            @endif
        @endforeach

        @if($totalNotif == 0)
            <li><a class="dropdown-item text-muted small text-center py-3"> </a></li>
        @endif
    </ul>
</li>



        </ul>
    </div>
</div>

    </nav>

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>

        <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
    @stack('scripts')

    <script>
async function fetchNotifikasi() {
    try {
        const response = await fetch('{{ route("api.notifikasi-combined") }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });
        
        if (!response.ok) throw new Error('Network response not ok');

        const data = await response.json();
        
        // Update badge
        const badge = document.getElementById('notifBadge');
        if (data.count > 0) {
            badge.textContent = data.count;
            badge.style.display = 'block';
        } else {
            badge.style.display = 'none';
        }

        // Update dropdown menu
        const dropdownMenu = document.getElementById('notifDropdownMenu');
        
        let menuHTML = '<li class="dropdown-header fw-bold">🔔 Notifikasi</li>';
        
        if (data.notifications && data.notifications.length > 0) {
            data.notifications.forEach((notif, index) => {
                const actionText = notif.type === 'peminjaman' ? 'mengajukan peminjaman' : 'mengajukan pengembalian';
                
                menuHTML += `
                    <li>
                        <a class="dropdown-item py-2" href="${notif.route || '#'}">
                            <div class="d-flex flex-column">
                                <span class="small">
                                    <strong>${notif.user_name}</strong> ${actionText} ${notif.nama_barang}
                                </span>
                                <small class="text-muted mt-1">
                                    <i class="fas fa-clock"></i> ${notif.created_at_human}
                                </small>
                            </div>
                        </a>
                    </li>
                `;
                
                // Add divider if not last item
                if (index < data.notifications.length - 1) {
                    menuHTML += '<li><hr class="dropdown-divider"></li>';
                }
            });
        } else {
            menuHTML += '<li><a class="dropdown-item text-muted small text-center py-3">Belum ada notifikasi</a></li>';
        }
        
        dropdownMenu.innerHTML = menuHTML;
        
    } catch (error) {
        console.error('Fetch notifikasi error:', error);
        const dropdownMenu = document.getElementById('notifDropdownMenu');
        if (dropdownMenu) {
            dropdownMenu.innerHTML = `
                <li class="dropdown-header fw-bold">🔔 Notifikasi</li>
                <li><a class="dropdown-item text-muted small text-center py-3">Gagal memuat</a></li>
            `;
        }
    }
}

// Initial load
document.addEventListener('DOMContentLoaded', function() {
    fetchNotifikasi();
    // Update every 5 seconds
    setInterval(fetchNotifikasi, 5000);
});
</script>
</body>
</html>

