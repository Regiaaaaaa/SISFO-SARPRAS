<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }
        .success { background-color: green; }
        .danger { background-color: red; }
        .warning { background-color: orange; color: black; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Pengembalian</h2>
    <p class="subtitle">Dicetak tanggal: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Barang</th>
                <th>Tgl Kembali</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengembalians as $data)
                <tr>
                    <td>{{ $data->peminjaman->user->name ?? '-' }}</td>
                    <td>{{ $data->peminjaman->barang->nama_barang ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_kembali)->format('d/m/Y') }}</td>
                    <td>{{ $data->deskripsi_pengembalian }}</td>
                    <td>
                        @php
                            $statusColor = [
                                'disetujui' => 'success',
                                'ditolak' => 'danger',
                                'menunggu' => 'warning',
                            ];
                        @endphp
                        <span class="badge {{ $statusColor[$data->status] ?? 'secondary' }}">
                            {{ ucfirst($data->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data pengembalian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
