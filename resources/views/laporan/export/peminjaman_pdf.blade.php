<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        h2 {
            margin-bottom: 0;
        }
        .subtitle {
            margin-top: 0;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Laporan Peminjaman</h2>
    <p class="subtitle">Dicetak tanggal: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $i => $data)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $data->user->name ?? '-' }}</td>
                <td>{{ $data->user->kelas ?? '-' }}</td>
                <td>{{ $data->user->jurusan ?? '-' }}</td>
                <td>{{ $data->barang->nama_barang ?? '-' }}</td>
                <td>{{ $data->jumlah }}</td>
                <td>{{ $data->digunakan_untuk }}</td>
                <td>{{ date('d/m/Y', strtotime($data->tanggal_pinjam)) }}</td>
                <td>{{ date('d/m/Y', strtotime($data->tanggal_kembali)) }}</td>
                <td>{{ ucfirst($data->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
