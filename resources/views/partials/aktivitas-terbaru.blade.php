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
    {{ \Carbon\Carbon::parse($a['waktu'])->translatedFormat('d M Y, H:i') }} WIB
</small>

        </div>
    </div>
@empty
    <div class="text-center text-muted py-4">
        <i class="fas fa-history mb-2 d-block text-muted"></i>
        Tidak ada aktivitas terbaru
    </div>
@endforelse
