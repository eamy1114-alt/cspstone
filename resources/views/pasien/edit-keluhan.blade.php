<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Keluhan Pasien - Rekam Medis Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #e0f2f1, #b2dfdb);
            color: #004d40;
            min-height: 100vh;
        }

        /* Header */
        header {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            flex-wrap: wrap;
        }

        .nav-right {
            display: flex;
            gap: 15px;
        }

        .nav-right a,
        .nav-right button {
            color: white;
            text-decoration: none;
            background: rgba(0, 0, 0, 0.1);
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        /* Container */
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        /* Card */
        .card {
            background: white;
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #00796b;
            font-size: 24px;
            margin-bottom: 10px;
            border-left: 4px solid #00796b;
            padding-left: 15px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
            margin-left: 19px;
        }

        /* Info Pasien */
        .info-pasien {
            background: linear-gradient(135deg, #e0f2f1 0%, #c8e6e0 100%);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #00796b;
        }

        .info-pasien p {
            margin: 8px 0;
            font-size: 15px;
        }

        .info-pasien strong {
            color: #004d40;
            width: 120px;
            display: inline-block;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .status-menunggu {
            background: #ff9800;
        }

        .status-diproses {
            background: #2196f3;
        }

        .status-selesai {
            background: #4caf50;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #004d40;
        }

        .required {
            color: #e57373;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #b2dfdb;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #009688;
            box-shadow: 0 0 0 3px rgba(0, 150, 136, 0.1);
        }

        textarea {
            resize: vertical;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        /* Section Title */
        .section-title {
            background: #e0f2f1;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 20px 0 15px 0;
            font-weight: 600;
            color: #004d40;
            font-size: 16px;
        }

        /* Buttons */
        .btn {
            background: #00796b;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background: #004d40;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #ccc;
            transform: translateY(-1px);
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        /* Alert */
        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #c8e6c9;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }

        .alert-error {
            background: #ffcdd2;
            color: #c62828;
            border-left: 4px solid #e57373;
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            text-align: center;
            padding: 12px;
            margin-top: 40px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
                padding: 15px;
            }

            .card {
                padding: 20px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .info-pasien strong {
                width: 100%;
                display: block;
                margin-bottom: 5px;
            }

            .button-group {
                flex-direction: column;
            }

            .button-group .btn {
                text-align: center;
            }
        }
    </style>
</head>
<body>

<header>
    <h2>✏️ Edit Keluhan & Data Medis Pasien</h2>
    <div class="nav-right">
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button type="submit">🚪 Logout</button>
        </form>
    </div>
</header>

<div class="container">
    <div class="card">
        <h2>Edit Keluhan Pasien</h2>
        <p class="subtitle">Perbaiki atau tambahkan informasi keluhan dan data pemeriksaan pasien</p>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <!-- Info Pasien -->
        <div class="info-pasien">
            <p><strong>👤 Nama Pasien:</strong> {{ $pasien->nama_lengkap }}</p>
            <p><strong>🎂 Usia:</strong> {{ $pasien->usia }} tahun</p>
            <p><strong>⚥ Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            <p><strong>📞 No. Telepon:</strong> {{ $pasien->no_telp ?? '-' }}</p>
            <p><strong>🏠 Alamat:</strong> {{ $pasien->alamat ?? '-' }}</p>
            <p><strong>📅 Tanggal Daftar:</strong> {{ \Carbon\Carbon::parse($pasien->created_at)->format('d/m/Y H:i') }}</p>
            <p><strong>📌 Status:</strong>
                <span class="status-badge status-{{ $pasien->status }}">
                    {{ $pasien->status == 'menunggu' ? 'Menunggu' : ($pasien->status == 'diproses' ? 'Diproses' : 'Selesai') }}
                </span>
            </p>
        </div>

        <!-- Form Edit -->
        <form method="POST" action="{{ route('pasien.update-keluhan', $pasien->id) }}">
            @csrf
            @method('PUT')

            <!-- Keluhan -->
            <div class="section-title">📝 Keluhan Pasien</div>
            <div class="form-group">
                <label>Keluhan Utama <span class="required">*</span></label>
                <textarea name="keluhan" rows="5" placeholder="Jelaskan keluhan pasien secara detail..." required>{{ old('keluhan', $pasien->keluhan) }}</textarea>
            </div>

            <!-- Data Pemeriksaan -->
            <div class="section-title">🩺 Data Pemeriksaan</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tekanan Darah (Tensi)</label>
                    <input type="text" name="tekanan_darah" value="{{ old('tekanan_darah', $pasien->tekanan_darah) }}" placeholder="Contoh: 120/80">
                </div>
                <div class="form-group">
                    <label>Suhu Tubuh (°C)</label>
                    <input type="number" name="suhu" step="0.1" value="{{ old('suhu', $pasien->suhu) }}" placeholder="Contoh: 36.5">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Berat Badan (kg)</label>
                    <input type="number" name="berat_badan" step="0.1" value="{{ old('berat_badan', $pasien->berat_badan) }}" placeholder="Contoh: 65">
                </div>
                <div class="form-group">
                    <label>Tinggi Badan (cm)</label>
                    <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan', $pasien->tinggi_badan) }}" placeholder="Contoh: 165">
                </div>
            </div>

            <!-- Catatan Perawat -->
            <div class="section-title">📋 Catatan Perawat</div>
            <div class="form-group">
                <label>Catatan Perawat</label>
                <textarea name="catatan_perawat" rows="3" placeholder="Catatan tambahan dari perawat...">{{ old('catatan_perawat', $pasien->catatan_perawat) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <a href="{{ route('dashboard.perawat') }}" class="btn btn-secondary">← Batal</a>
                <button type="submit" class="btn">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<footer>
    © 2025 Rekam Medis Digital | Data Kesehatan Anda Aman & Terlindungi | Enkripsi AES-256
</footer>

</body>
</html>