<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rekam Medis Saya - Rekam Medis Digital</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: linear-gradient(120deg, #e0f2f1, #b2dfdb);
            color: #004d40;
        }

        header {
            background: linear-gradient(90deg, #009688, #4db6ac);
            padding: 18px 40px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }

        header h2 {
            margin: 0;
            font-weight: 600;
        }

        .nav-right a {
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            background-color: rgba(255,255,255,0.15);
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-right a:hover {
            background-color: rgba(255,255,255,0.3);
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .rekam-card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            margin-bottom: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .rekam-card h3 {
            margin: 0 0 10px;
            color: #00796b;
            border-bottom: 2px solid #b2dfdb;
            padding-bottom: 10px;
        }

        .info {
            margin-top: 12px;
        }

        .info strong {
            color: #004d40;
        }

        .btn-download, .btn-view {
            display: inline-block;
            margin-top: 12px;
            padding: 10px 15px;
            background-color: #009688;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
            font-size: 14px;
        }

        .btn-download:hover, .btn-view:hover {
            background-color: #004d40;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-success { background: #c8e6c9; color: #2e7d32; }
        .alert-error { background: #ffcdd2; color: #c62828; }
        .alert-info { background: #e3f2fd; color: #1565c0; }

        footer {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            text-align: center;
            padding: 14px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h2>📋 Rekam Medis Saya</h2>
    <div class="nav-right">
        <a href="{{ url('/dashboard/pasien') }}">🏠 Dashboard</a>
        <form method="POST" action="{{ url('/logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; cursor:pointer;">🚪 Logout</button>
        </form>
    </div>
</header>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if($rekamMedis->isEmpty())
        <div class="alert alert-info">📭 Belum ada rekam medis untuk Anda.</div>
    @endif

    @foreach($rekamMedis as $index => $rm)
    <div class="rekam-card">
        <h3>Rekam Medis #{{ $loop->iteration }}</h3>
        <div class="info"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($rm->tanggal_pemeriksaan)->format('d F Y') }}</div>
        <div class="info"><strong>Nama Pasien:</strong> {{ $rm->pasien->nama_lengkap ?? '-' }}</div>
        <div class="info"><strong>Diagnosa:</strong> {{ $rm->diagnosa }}</div>
        <div class="info"><strong>Obat:</strong> {{ $rm->obat }}</div>
        <div class="info"><strong>Alergi:</strong> {{ $rm->alergi ?? 'Tidak ada' }}</div>
        <div class="info"><strong>Dokter:</strong> {{ $rm->dokter->name ?? '-' }}</div>
        <div class="info"><strong>Rumah Sakit:</strong> {{ $rm->rumah_sakit }}</div>

        @if($rm->foto_rontgen)
        <div class="info"><strong>Foto Rontgen:</strong></div>
        <a href="{{ Storage::url($rm->foto_rontgen) }}" target="_blank" class="btn-view">📷 Lihat Rontgen</a>
        @endif

        @if($rm->hasil_lab)
        <div class="info"><strong>Hasil Lab:</strong></div>
        <a href="{{ Storage::url($rm->hasil_lab) }}" target="_blank" class="btn-download">📄 Download Hasil Lab (PDF)</a>
        @endif
    </div>
    @endforeach
</div>

<footer>
    © 2025 Rekam Medis Digital – Akses Data Kesehatan Aman | Data Terenkripsi AES-256
</footer>

</body>
</html>