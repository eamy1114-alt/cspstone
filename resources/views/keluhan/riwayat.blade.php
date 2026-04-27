<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Keluhan - Rekam Medis Digital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #e0f2f1, #b2dfdb);
            min-height: 100vh;
        }
        header {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
        }
        .container { max-width: 1000px; margin: 40px auto; padding: 20px; }
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 { color: #00796b; margin-bottom: 20px; }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-menunggu { background: #fff3e0; color: #e65100; }
        .status-diproses { background: #e3f2fd; color: #1565c0; }
        .status-selesai { background: #e8f5e9; color: #2e7d32; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th { background: #009688; color: white; }
        .btn-back {
            background: #00796b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        footer {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            text-align: center;
            padding: 12px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h2>📋 Riwayat Keluhan Saya</h2>
    <div>
        {{ auth()->user()->name }}
        <form method="POST" action="{{ url('/logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; cursor:pointer;">Logout</button>
        </form>
    </div>
</header>

<div class="container">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Riwayat Keluhan</h2>
            <a href="{{ url('/keluhan/create') }}" class="btn-back">+ Buat Keluhan Baru</a>
        </div>

        @if($riwayat->isEmpty())
            <p style="text-align: center; padding: 40px;">Belum ada keluhan yang dikirim.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keluhan</th>
                        <th>Tekanan Darah</th>
                        <th>Suhu</th>
                        <th>Status</th>
                        <th>Dokter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $item)
                    <tr>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ Str::limit($item->keluhan, 50) }}</td>
                        <td>{{ $item->tekanan_darah ?? '-' }}</td>
                        <td>{{ $item->suhu ?? '-' }} °C</td>
                        <td>
                            <span class="status status-{{ $item->status }}">
                                {{ $item->status == 'menunggu' ? 'Menunggu' : ($item->status == 'diproses' ? 'Diproses' : 'Selesai') }}
                            </span>
                        </td>
                        <td>{{ $item->dokter->name ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div style="margin-top: 20px;">
            <a href="{{ url('/dashboard/pasien') }}" class="btn-back">← Kembali ke Dashboard</a>
        </div>
    </div>
</div>

<footer>
    © 2025 Rekam Medis Digital | Data Kesehatan Anda Aman & Terlindungi
</footer>

</body>
</html>