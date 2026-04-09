<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .text-center { text-align: center; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .badge { padding: 3px 7px; border-radius: 4px; color: white; }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: #000; }
    </style>
</head>
<body>
    <div class="header text-center">
        <h2>LAPORAN DATA PENGADUAN MASYARAKAT</h2>
        <p>Periode: {{ request('from') ?? '-' }} s/d {{ request('to') ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Kategori</th>
                <th>Subjek</th>
                <th>Status</th>
                <th>Admin Response</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>{{ $item->nik }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->subject }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->admin_response }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>