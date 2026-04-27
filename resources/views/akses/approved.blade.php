<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Akses Disetujui - Rekam Medis Digital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #e0f2f1, #b2dfdb);
            color: #004d40;
            min-height: 100vh;
        }
        header {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            flex-wrap: wrap;
        }
        .nav-right { display: flex; gap: 15px; }
        .nav-right a, .nav-right button {
            color: white;
            text-decoration: none;
            background: rgba(0,0,0,0.1);
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }
        .container { display: flex; min-height: calc(100vh - 80px); }
        .sidebar {
            width: 260px;
            background: white;
            padding: 20px;
            text-align: center;
        }
        .profile-sidebar img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid #009688;
            margin-bottom: 10px;
        }
        .profile-sidebar h4 { margin: 10px 0 5px; }
        .sidebar a {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            text-align: left;
            text-decoration: none;
            color: #004d40;
            border-radius: 6px;
        }
        .sidebar a:hover, .sidebar a.active { background: #b2dfdb; }
        .content { flex: 1; padding: 25px; }
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 { color: #00796b; margin-bottom: 20px; border-bottom: 2px solid #b2dfdb; padding-bottom: 10px; }
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
        .btn {
            background: #00796b;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
        }
        .btn-sm { padding: 4px 10px; font-size: 11px; }
        .table-wrapper { overflow-x: auto; }
        .sisa-waktu {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            display: inline-block;
        }
        .sisa-waktu-expired {
            background: #ffcdd2;
            color: #c62828;
        }
        footer {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            text-align: center;
            padding: 12px;
            margin-top: auto;
        }
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .sidebar { width: 100%; display: flex; gap: 10px; overflow-x: auto; }
            .sidebar a { white-space: nowrap; }
            th, td { font-size: 12px; padding: 8px; }
        }
    </style>
</head>
<body>

<header>
    <h2>🔑 Akses Rekam Medis Disetujui</h2>
    <div class="nav-right">
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button type="submit">🚪 Logout</button>
        </form>
    </div>
</header>

<div class="container">
    <div class="sidebar">
        <div class="profile-sidebar">
            <img src="https://cdn-icons-png.flaticon.com/512/387/387561.png">
            <h4>dr. {{ auth()->user()->name ?? 'Dokter' }}</h4>
            <p>{{ auth()->user()->id_dokter ?? '-' }}</p>
            <p>{{ auth()->user()->poli ?? 'Umum' }}</p>
        </div>
        <a href="{{ route('dashboard.dokter') }}">🏠 Dashboard</a>
        <a href="{{ route('akses.approved') }}" class="active">🔑 Akses Disetujui</a>
        <a href="#">📋 Rekam Medis</a>
    </div>

    <div class="content">
        <div class="card">
            <h2>📋 Daftar Pasien yang Memberikan Akses</h2>
            
            @if($akses->isEmpty())
                <p style="text-align: center; padding: 40px;">Belum ada pasien yang memberikan akses.</p>
            @else
                <div class="table-wrapper">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Sisa Waktu Akses</th>
                                <th>Tanggal Disetujui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($akses as $index => $item)
                            @php
                                $isExpired = $item->expired_at && \Carbon\Carbon::now()->greaterThan($item->expired_at);
                                $sisaWaktuClass = $isExpired ? 'sisa-waktu-expired' : '';
                                $sisaWaktuText = '';
                                if ($isExpired) {
                                    $sisaWaktuText = '❌ Kedaluwarsa';
                                } elseif ($item->expired_at) {
                                    $diff = \Carbon\Carbon::now()->diff($item->expired_at);
                                    if ($diff->h > 0) {
                                        $sisaWaktuText = '⏱️ ' . $diff->h . ' jam ' . $diff->i . ' menit';
                                    } else {
                                        $sisaWaktuText = '⏱️ ' . $diff->i . ' menit';
                                    }
                                } else {
                                    $sisaWaktuText = '♾️ Selamanya';
                                }
                            @endphp
                            <tr>
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $item->pasien_nama_lengkap ?? $item->pasien->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <span class="sisa-waktu {{ $sisaWaktuClass }}">
                                        {{ $sisaWaktuText }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2">
                                    @if($item->pasien_data_id && !$isExpired)
                                        <a href="{{ route('rekam-medis.pasien', $item->pasien_data_id) }}" class="btn btn-sm">
                                            📋 Lihat Semua Rekam Medis
                                        </a>
                                    @elseif($isExpired)
                                        <span class="text-gray-500" style="color: #999; font-size: 11px;">
                                            ⚠️ Akses Kedaluwarsa
                                        </span>
                                    @else
                                        <span class="text-gray-500" style="color: #999; font-size: 11px;">
                                            Data tidak tersedia
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<footer>
    © 2025 Rekam Medis Digital | Data Kesehatan Anda Aman & Terlindungi
</footer>

</body>
</html>