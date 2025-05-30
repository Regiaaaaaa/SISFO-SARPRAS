<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\BarangController;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\Laporan\LaporanPeminjamanController;
use App\Http\Controllers\Laporan\LaporanPengembalianController;
use App\Http\Controllers\Laporan\LaporanStokController;
use App\Http\Controllers\NotifikasiController;


// --------------------
// WEB ROUTES (routes/web.php)
// --------------------

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

//Login view 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

//Login post khusus web admin
Route::post('/login', [AuthController::class, 'loginWeb'])->name('login.submit');

//Logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

//hanya bisa diakses oleh admin
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategori', KategoriBarangController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('users', UserController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('pengembalian',PengembalianController::class);
    

    // Laporan Peminjaman
    Route::get('/laporan/peminjaman', [LaporanPeminjamanController::class, 'index'])->name('laporan.peminjaman');
    Route::get('/laporan/peminjaman/pdf', [LaporanPeminjamanController::class, 'exportPdf'])->name('laporan.peminjaman.pdf');
    Route::get('/laporan/peminjaman/excel', [LaporanPeminjamanController::class, 'exportExcel'])->name('laporan.peminjaman.excel');

    // Laporan Pengembalian
    Route::get('/laporan/pengembalian', [LaporanPengembalianController::class, 'index'])->name('laporan.pengembalian');
    Route::get('/laporan/pengembalian/pdf', [LaporanPengembalianController::class, 'exportPdf'])->name('laporan.pengembalian.pdf');
    Route::get('/laporan/pengembalian/excel', [LaporanPengembalianController::class, 'exportExcel'])->name('laporan.pengembalian.excel');

    // Laporan Stok Barang
    Route::get('/laporan/stok', [LaporanStokController::class, 'index'])->name('laporan.stok');
    Route::get('/laporan/stok/pdf', [LaporanStokController::class, 'exportPdf'])->name('laporan.stok.pdf');
    Route::get('/laporan/stok/excel', [LaporanStokController::class, 'exportExcel'])->name('laporan.stok.excel');

    // Notifikasi Pinjam & Kembali
    Route::get('/notifikasi-peminjaman', [NotifikasiController::class, 'getPeminjamanMenunggu'])->name('notifikasi.peminjaman');
    Route::get('/notifikasi-pengembalian', [NotifikasiController::class, 'getPengembalianTerbaru'])->name('api.notifikasi-pengembalian');

    Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/stok', [LaporanStokController::class, 'index'])->name('stok');
    Route::get('/stok/pdf', [LaporanStokController::class, 'exportPdf'])->name('stok.pdf');
    Route::get('/stok/excel', [LaporanStokController::class, 'exportExcel'])->name('stok.excel');
});


    
Route::get('/dashboard/aktivitas-terbaru', function () {
    $peminjaman = Peminjaman::with(['user', 'barang'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get()
        ->map(function ($p) {
            return [
                'tipe' => 'peminjaman',
                'user' => $p->user->name ?? 'User #' . $p->user_id,
                'barang' => $p->barang->nama_barang ?? 'Barang #' . $p->barang_id,
                'waktu' => $p->created_at,
            ];
        });

    $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.barang'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get()
        ->map(function ($k) {
            return [
                'tipe' => 'pengembalian',
                'user' => $k->peminjaman->user->name ?? 'User #' . $k->peminjaman->user_id,
                'barang' => $k->peminjaman->barang->nama_barang ?? 'Barang #' . $k->peminjaman->barang_id,
                'waktu' => $k->created_at,
            ];
        });

    // Gabungkan dan urutkan berdasarkan waktu terbaru
    $aktivitas = $peminjaman->merge($pengembalian)->sortByDesc('waktu')->take(8);

    $html = '';
    foreach ($aktivitas as $a) {
        $html .= '<div class="d-flex align-items-start py-3 border-bottom border-light">';
        $html .= '<div class="icon-circle-sm ' . ($a['tipe'] === 'peminjaman' ? 'bg-primary' : 'bg-success') . ' bg-opacity-10 me-3 mt-1">';
        $html .= '<i class="fas ' . ($a['tipe'] === 'peminjaman' ? 'fa-hand-holding text-primary' : 'fa-undo text-success') . '"></i>';
        $html .= '</div>';
        $html .= '<div class="flex-grow-1">';
        $html .= '<p class="mb-1"><strong>' . $a['user'] . '</strong> ';
        $html .= ($a['tipe'] === 'peminjaman' ? 'melakukan peminjaman' : 'melakukan pengembalian') . ' ';
        $html .= '<strong>' . $a['barang'] . '</strong></p>';
        $html .= '<small class="text-muted"><i class="fas fa-clock me-1"></i>' . \Carbon\Carbon::parse($a['waktu'])->translatedFormat('d M Y, H:i') . ' WIB</small>';

        $html .= '</div></div>';
    }

    return $html ?: '<div class="text-center text-muted py-4"><i class="fas fa-history mb-2 d-block text-muted"></i>Tidak ada aktivitas terbaru</div>';
})->name('dashboard.aktivitas-terbaru');


 // Route API untuk notifikasi gabungan (peminjaman + pengembalian)
Route::get('/api/notifikasi-combined', function () {
    // Get peminjaman notifications
    $peminjamanTerbaru = Peminjaman::with('user', 'barang')
        ->where('status', 'menunggu')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // Get pengembalian notifications  
    $pengembalianTerbaru = \App\Models\Pengembalian::with(['peminjaman.user', 'peminjaman.barang'])
        ->where('status', 'menunggu') // Add status filter if needed
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    $notifications = [];

    // Format peminjaman notifications
    foreach ($peminjamanTerbaru as $p) {
        $notifications[] = [
            'id' => 'peminjaman_' . $p->id,
            'type' => 'peminjaman',
            'user_name' => $p->user->name,
            'nama_barang' => $p->barang->nama_barang,
            'created_at_human' => \Carbon\Carbon::parse($p->created_at)->diffForHumans(),
            'created_at' => $p->created_at,
            'route' => route('peminjaman.index')
        ];
    }

    // Format pengembalian notifications
    foreach ($pengembalianTerbaru as $k) {
        $notifications[] = [
            'id' => 'pengembalian_' . $k->pengembalian_id,
            'type' => 'pengembalian',
            'user_name' => $k->peminjaman->user->name ?? 'User #' . $k->peminjaman->user_id,
            'nama_barang' => $k->peminjaman->barang->nama_barang ?? 'Barang #' . $k->peminjaman->barang_id,
            'created_at_human' => \Carbon\Carbon::parse($k->created_at)->diffForHumans(),
            'created_at' => $k->created_at,
            'route' => route('pengembalian.index')
        ];
    }

    // Sort by created_at (newest first)
    usort($notifications, function($a, $b) {
        return $b['created_at'] <=> $a['created_at'];
    });

    // Take only 5 most recent
    $notifications = array_slice($notifications, 0, 5);

    return response()->json([
        'count' => count($notifications),
        'notifications' => $notifications,
    ]);
})->name('api.notifikasi-combined');

});
