<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Barang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 11px;
            color: white;
        }

        .success { background-color: green; }
        .warning { background-color: orange; color: black; }
        .danger { background-color: red; }
        .primary { background-color: #0d6efd; }
        .secondary { background-color: gray; }
    </style>
</head>
<body>
    <h2>Laporan Stok Barang</h2>
        <p class="subtitle">Dicetak tanggal: {{ date('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Merek</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $barang)
                <tr>
                    <td>{{ $barang->code_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                    <td><span class="badge primary">{{ $barang->stok }}</span></td>
                    <td>{{ $barang->merek }}</td>
                    <td>
                        @php
                            $kondisi = strtolower($barang->kondisi_barang);
                            $badgeClass = match($kondisi) {
                                'baik' => 'success',
                                'rusak ringan' => 'warning',
                                'rusak berat' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($kondisi) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
