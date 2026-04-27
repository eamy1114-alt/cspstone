<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rekam Medis Pasien - Rekam Medis Digital</title>
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
        .container { max-width: 1000px; margin: 40px auto; padding: 20px; }
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 { color: #00796b; margin-bottom: 20px; border-bottom: 2px solid #b2dfdb; padding-bottom: 10px; }
        h3 { color: #00796b; margin-bottom: 15px; }
        .rekam-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 0;
        }
        .rekam-item:last-child { border-bottom: none; }
        .btn {
            background: #00796b;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .btn-back {
            background: #6c757d;
        }
        .btn-back:hover { background: #5a6268; }
        .btn:hover { background: #004d40; }
        footer {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            text-align: center;
            padding: 12px;
            margin-top: 40px;
        }
        @media (max-width: 768px) {
            .container { margin: 20px auto; }
            .rekam-item { font-size: 14px; }
        }
    </style>
</head>
<body>

<header>
    <h2>📋 Rekam Medis Pasien</h2>
    <div class="nav-right">
        <span>{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ url('/logout') }}" style="display:inline;">
            @csrf
            <button type="submit">🚪 Logout</button>
        </form>
    </div>
</header>

<div class="container">
    <div class="card">
        <h2>Riwayat Rekam Medis</h2>
        <h3>Nama Pasien: {{ $pasien->nama_lengkap ?? 'Pasien' }}</h3>
        
        @if($rekamMedis->isEmpty())
            <p style="text-align: center; padding: 40px;">Belum ada rekam medis untuk pasien ini.</p>
        @else
            @foreach($rekamMedis as $rm)
            <div class="rekam-item">
                <p><strong>📅 Tanggal:</strong> {{ \Carbon\Carbon::parse($rm->tanggal_pemeriksaan)->format('d F Y') }}</p>
                <p><strong>🩺 Diagnosa:</strong> {{ Str::limit($rm->diagnosa, 100) }}</p>
                <p><strong>💊 Obat:</strong> {{ Str::limit($rm->obat, 100) }}</p>
                <p><strong>👨‍⚕️ Dokter:</strong> {{ $rm->dokter->name ?? '-' }}</p>
                <p><strong>🏥 Rumah Sakit:</strong> {{ $rm->rumah_sakit }}</p>
                <a href="{{ route('rekam-medis.show', $rm->id) }}" class="btn btn-sm">📋 Detail</a>
            </div>
            @endforeach
        @endif
        
        <div style="margin-top: 20px;">
            <a href="{{ route('akses.approved') }}" class="btn btn-back">← Kembali ke Daftar Akses</a>
        </div>
    </div>
</div>

<footer>
    © 2025 Rekam Medis Digital | Data Kesehatan Anda Aman & Terlindungi
</footer>

</body>
</html>